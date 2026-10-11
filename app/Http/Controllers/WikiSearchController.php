<?php

namespace App\Http\Controllers;

use App\Models\WikiPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WikiSearchController extends Controller
{
    public function index(Request $request): View
    {
        $query   = trim((string) $request->input('q', ''));
        $results = collect();

        if (mb_strlen($query) >= 2) {
            $results = $this->search($query);
        }

        return view('wiki.search', [
            'query'   => $query,
            'results' => $results,
        ]);
    }

    protected function search(string $query)
    {
        // 1) Пытаемся FULLTEXT с рейтингом
        try {
            $ids = $this->fulltextIds($query);
            if ($ids->isNotEmpty()) {
                return $this->decorate($ids, $query);
            }
        } catch (\Throwable $e) {
            // FULLTEXT может не поддерживаться — падаем в fallback
        }

        // 2) Fallback: LIKE
        $ids = WikiPage::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->orderByDesc('views_count')
            ->limit(50)
            ->pluck('id');

        return $this->decorate($ids, $query);
    }

    /**
     * FULLTEXT-ранжирование: title × 3, excerpt × 2, content × 1.
     * Возвращает коллекцию ID, упорядоченных по релевантности.
     */
    protected function fulltextIds(string $query)
    {
        // Получаем базовый релевантный список через MATCH AGAINST
        $rows = DB::select(
            "SELECT id,
                    MATCH(title, excerpt, content) AGAINST (? IN NATURAL LANGUAGE MODE) AS score
             FROM wiki_pages
             WHERE status = 'published'
               AND published_at IS NOT NULL
               AND published_at <= NOW()
               AND MATCH(title, excerpt, content) AGAINST (? IN NATURAL LANGUAGE MODE)
             ORDER BY score DESC
             LIMIT 50",
            [$query, $query]
        );

        if (!$rows) {
            return collect();
        }

        $ids = collect($rows)->pluck('id');

        // Догружаем модели и добавляем boost
        $pages = WikiPage::whereIn('id', $ids)
            ->with('category')
            ->get()
            ->keyBy('id');

        $needle = mb_strtolower($query);

        return $ids->map(function ($id) use ($pages, $needle) {
            $p = $pages->get($id);
            if (!$p) return null;

            $score = 0.0;
            $title  = mb_strtolower($p->title ?? '');
            $excerpt = mb_strtolower($p->excerpt ?? '');
            $content = mb_strtolower(strip_tags($p->content ?? ''));

            // Boost'ы
            if (str_contains($title, $needle))        $score += 30;
            if (str_starts_with($title, $needle))     $score += 50;
            if (str_contains($excerpt, $needle))      $score += 15;
            if (str_contains($content, $needle))      $score += 5;

            // views как tie-break
            $score += min(10, log10(max(1, (int) $p->views_count)) * 5);

            $p->_search_score = $score;
            return $p;
        })->filter()->sortByDesc('_search_score')->values();
    }

    /**
     * Догрузка и подготовка сниппетов/подсветки.
     */
    protected function decorate($ids, string $query)
    {
        if (!($ids instanceof \Illuminate\Support\Collection)) {
            $ids = collect($ids);
        }

        // Если пришли "сырые" ID (fallback) — грузим модели
        if ($ids->isNotEmpty() && is_numeric($ids->first())) {
            $pages = WikiPage::whereIn('id', $ids)
                ->with('category')
                ->get()
                ->keyBy('id');
            $ids = $ids->map(fn ($id) => $pages->get($id))->filter();
        }

        return $ids->map(function (WikiPage $p) use ($query) {
            // Сниппет
            $haystack = $p->excerpt ?: strip_tags($p->content ?? '');
            $p->_snippet_html = $this->snippet($haystack, $query, 220);

            // Заголовок с подсветкой
            $p->_title_html = $this->highlight(e($p->title), $query);

            return $p;
        });
    }

    /**
     * Возвращает HTML сниппета с подсветкой найденной фразы.
     */
    protected function snippet(string $text, string $query, int $len = 220): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', $text));
        if ($text === '') return '';

        $pos = mb_stripos($text, $query);
        if ($pos === false) {
            $out = mb_substr($text, 0, $len);
            if (mb_strlen($text) > $len) $out .= '…';
            return e($out);
        }

        $start = max(0, $pos - (int) ($len / 3));
        $slice = mb_substr($text, $start, $len);
        if ($start > 0) $slice = '…' . $slice;
        if ($start + $len < mb_strlen($text)) $slice .= '…';

        return $this->highlight(e($slice), $query);
    }

    /**
     * Подсветка <mark> без экранирования HTML внутри фразы.
     */
    protected function highlight(string $escaped, string $query): string
    {
        if ($query === '') return $escaped;
        $pattern = '#' . preg_quote(e($query), '#') . '#iu';
        return preg_replace($pattern, '<mark>$0</mark>', $escaped) ?? $escaped;
    }
}