<?php

namespace App\Http\Controllers;

use App\Models\WikiPage;
use Illuminate\View\View;

class WikiPageController extends Controller
{
    public function index(): View
    {
        $pages = WikiPage::where('status', 'published')
            ->with('category')
            ->orderByDesc('updated_at')
            ->paginate(30);

        return view('wiki.pages', compact('pages'));
    }

    public function show(WikiPage $page): View
    {
        abort_unless($page->status === 'published', 404);

        $page->increment('views_count');

        $page->load(['category', 'author', 'tags']);

        $related = WikiPage::where('category_id', $page->category_id)
            ->where('id', '!=', $page->id)
            ->where('status', 'published')
            ->limit(5)
            ->get();

        return view('wiki.page', compact('page', 'related'));
    }
}
