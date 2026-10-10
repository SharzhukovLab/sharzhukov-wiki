<?php

namespace App\Http\Controllers;

use App\Models\WikiCategory;
use App\Models\WikiPage;
use App\Models\WikiTag;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls   = [];
        $urls[] = ['loc' => url('/'),           'changefreq' => 'weekly', 'priority' => '1.0'];
        $urls[] = ['loc' => url('/pages'),      'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => url('/categories'), 'changefreq' => 'weekly', 'priority' => '0.7'];
        $urls[] = ['loc' => url('/tags'),       'changefreq' => 'weekly', 'priority' => '0.6'];

        $pageQ = WikiPage::query();
        if (Schema::hasColumn('wiki_pages', 'is_published')) {
            $pageQ->where('is_published', true);
        } elseif (Schema::hasColumn('wiki_pages', 'status')) {
            $pageQ->where('status', 'published');
        }
        foreach ($pageQ->get() as $page) {
            $urls[] = [
                'loc'        => url('/p/' . $page->slug),
                'lastmod'    => optional($page->updated_at)->toAtomString(),
                'changefreq' => 'monthly',
                'priority'   => '0.8',
            ];
        }

        foreach (WikiCategory::all() as $cat) {
            $urls[] = ['loc' => url('/c/' . $cat->slug), 'changefreq' => 'weekly', 'priority' => '0.6'];
        }
        foreach (WikiTag::all() as $tag) {
            $urls[] = ['loc' => url('/t/' . $tag->slug), 'changefreq' => 'weekly', 'priority' => '0.5'];
        }

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$u['loc']}</loc>\n";
            if (!empty($u['lastmod'])) $xml .= "    <lastmod>{$u['lastmod']}</lastmod>\n";
            $xml .= "    <changefreq>{$u['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$u['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function robots(): Response
    {
        $content  = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /api\n";
        $content .= "\n";
        $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}