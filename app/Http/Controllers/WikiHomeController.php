<?php

namespace App\Http\Controllers;

use App\Models\WikiCategory;
use App\Models\WikiPage;
use App\Models\WikiTag;
use Illuminate\View\View;

class WikiHomeController extends Controller
{
    public function index(): View
    {
        $categories = WikiCategory::where('is_visible', true)
            ->whereNull('parent_id')
            ->withCount('pages')
            ->orderBy('sort_order')
            ->get();

        $recentPages = WikiPage::where('status', 'published')
            ->with('category')
            ->orderByDesc('updated_at')
            ->limit(6)
            ->get();

        $pinnedPages = WikiPage::where('status', 'published')
            ->where('is_pinned', true)
            ->orderByDesc('updated_at')
            ->limit(3)
            ->get();

        $tags = WikiTag::withCount('pages')
            ->orderByDesc('pages_count')
            ->limit(20)
            ->get();

        return view('wiki.home', compact('categories', 'recentPages', 'pinnedPages', 'tags'));
    }
}
