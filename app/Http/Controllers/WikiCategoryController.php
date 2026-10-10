<?php

namespace App\Http\Controllers;

use App\Models\WikiCategory;
use App\Models\WikiPage;
use Illuminate\View\View;

class WikiCategoryController extends Controller
{
    public function index(): View
    {
        $categories = WikiCategory::where('is_visible', true)
            ->whereNull('parent_id')
            ->with(['children' => fn ($q) => $q->where('is_visible', true)])
            ->withCount('pages')
            ->orderBy('sort_order')
            ->get();

        return view('wiki.categories', compact('categories'));
    }

    public function show(WikiCategory $category): View
    {
        abort_unless($category->is_visible, 404);

        $pages = WikiPage::where('category_id', $category->id)
            ->where('status', 'published')
            ->orderByDesc('is_pinned')
            ->orderBy('sort_order')
            ->orderByDesc('updated_at')
            ->paginate(20);

        $children = $category->children()
            ->where('is_visible', true)
            ->withCount('pages')
            ->orderBy('sort_order')
            ->get();

        return view('wiki.category', compact('category', 'pages', 'children'));
    }
}
