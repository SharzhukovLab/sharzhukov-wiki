<?php

namespace App\Http\Controllers;

use App\Models\WikiPage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WikiSearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->input('q', ''));

        $results = collect();
        if (strlen($query) >= 2) {
            $results = WikiPage::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('excerpt', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                })
                ->with('category')
                ->orderByDesc('views_count')
                ->limit(50)
                ->get();
        }

        return view('wiki.search', compact('query', 'results'));
    }
}
