<?php

namespace App\Http\Controllers;

use App\Models\WikiPage;
use App\Models\WikiTag;
use Illuminate\View\View;

class WikiTagController extends Controller
{
    public function index(): View
    {
        $tags = WikiTag::withCount('pages')
            ->orderByDesc('pages_count')
            ->orderBy('name')
            ->get();

        return view('wiki.tags', compact('tags'));
    }

    public function show(WikiTag $tag): View
    {
        $pages = $tag->pages()
            ->where('status', 'published')
            ->orderByDesc('updated_at')
            ->paginate(20);

        return view('wiki.tag', compact('tag', 'pages'));
    }
}
