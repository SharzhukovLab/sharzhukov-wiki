@props(['title' => null, 'description' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? "Sharzhukov Wiki" }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#ff5c1f">
    <meta name="description" content="Documentation for Sharzhukov's Laboratory projects and technologies.">
    @stack('meta')
    <script>
        (function () {
            var t = localStorage.getItem('theme');
            var dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (t === 'dark' || (!t && dark)) document.documentElement.classList.add('dark');
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SEO + Open Graph --}}
    <meta name="description" content="{{ $description ?? 'Sharzhukov\'s Laboratory — open-source collective building tools for developers.' }}">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $description ?? 'Open-source collective building tools for developers. Made in EU.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Sharzhukov's Laboratory">
    <meta property="og:image" content="{{ url('/img/branding/core-white.png') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? config('app.name') }}">
    <meta name="twitter:description" content="{{ $description ?? 'Open-source collective building tools for developers.' }}">

    <link rel="canonical" href="{{ url()->current() }}">
</head>
<body>

<nav class="brutal-nav">
    <div class="brutal-nav-inner">
        <a href="{{ url('/') }}" style="display:flex;align-items:center;gap:12px;text-decoration:none;">
            <img src="{{ asset('img/branding/core-white.png') }}" alt="Core" style="height:32px;width:auto;filter:drop-shadow(2px 2px 0 var(--brutal-shadow));">
            <div style="display:flex;flex-direction:column;line-height:1;">
                <span style="font-family:var(--font-sans);font-weight:900;font-size:14px;letter-spacing:-0.02em;color:var(--brutal-border);">SHARZHUKOV WIKI</span>
                <span style="font-family:var(--font-mono);font-size:9px;font-weight:700;letter-spacing:0.15em;color:var(--brutal-border);opacity:.6;">// KNOWLEDGE</span>
            </div>
        </a>

        <div style="flex:1;display:flex;gap:4px;margin-left:16px;">
            <a href="{{ url('/categories') }}" class="brutal-nav-link {{ request()->is('categories*') ? 'active' : '' }}">Categories</a>
            <a href="{{ url('/pages') }}" class="brutal-nav-link {{ request()->is('pages*') ? 'active' : '' }}">All pages</a>
            <a href="{{ url('/tags') }}" class="brutal-nav-link {{ request()->is('tags*') ? 'active' : '' }}">Tags</a>
            <a href="https://main.sharzhukov.com" class="brutal-nav-link" target="_blank">Main ↗</a>
        </div>

        <form method="GET" action="{{ url('/search') }}" style="display:flex;align-items:center;">
            <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}" style="height:34px;padding:0 12px;border:2px solid var(--brutal-border);background:var(--lab-bg);color:var(--lab-fg);font-family:var(--font-mono);font-size:12px;outline:none;width:180px;">
        </form>

        <button type="button" class="lab-theme-toggle" onclick="toggleLabTheme()" aria-label="Toggle theme" style="border:2px solid var(--brutal-border);border-radius:0;box-shadow:2px 2px 0 var(--brutal-shadow);">
            <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
            <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </button>

        @auth
            <a href="https://account-main.sharzhukov.com/dashboard" style="text-decoration:none;display:inline-flex;">
                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" style="width:36px;height:36px;border-radius:0;object-fit:cover;border:2px solid var(--brutal-border);filter:drop-shadow(3px 3px 0 var(--brutal-shadow));">
            </a>
        @else
            <x-lab::button variant="primary" size="sm" href="https://account-main.sharzhukov.com/login?return={{ urlencode(url('/')) }}">
                SIGN IN →
            </x-lab::button>
        @endauth
    </div>
</nav>

<main>{{ $slot }}</main>

<x-lab::site-footer context="wiki" />

<script>
    function toggleLabTheme() {
        var d = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', d ? 'dark' : 'light');
    }
</script>
<x-lab::cookie-consent />
</body>
</html>
