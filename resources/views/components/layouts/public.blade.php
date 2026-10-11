@props(['title' => null, 'description' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? "Sharzhukov Wiki" }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#ff5c1f">
    {{-- Favicon --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/branding/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/branding/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/branding/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="description" content="Documentation for Sharzhukov's Laboratory projects and technologies.">
    @stack('meta')
        <script>
        (function () {
    var V = 'v2-2026-10-11';
    if (localStorage.getItem('theme_version') !== V) {
        localStorage.removeItem('theme');
        localStorage.setItem('theme_version', V);
    }
    var t = localStorage.getItem('theme');
    if (t === 'dark') document.documentElement.classList.add('dark');
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
    <x-lab::analytics />

</head>
<body>

<x-lab::site-nav
    brand-title="SHARZHUKOV WIKI"
    brand-sub="// KNOWLEDGE"
    :items="[
        ['label' => 'Categories', 'url' => '/categories'],
        ['label' => 'All pages',  'url' => '/pages'],
        ['label' => 'Tags',       'url' => '/tags'],
        ['label' => 'Main ↗',     'url' => 'https://sharzhukov.com', 'external' => true],
    ]"
>
    <form method="GET" action="{{ url('/search') }}" class="brutal-nav-search">
        <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}"
               style="height:34px;padding:0 12px;border:2px solid var(--brutal-border);background:var(--lab-bg);color:var(--lab-fg);font-family:var(--font-mono);font-size:12px;outline:none;width:180px;">
    </form>
    <x-slot:drawer>
        <form method="GET" action="{{ url('/search') }}" style="display:flex;flex-direction:column;gap:8px;">
            <label for="nav-search-q" style="font-family:var(--font-mono);font-size:11px;font-weight:700;letter-spacing:0.15em;color:var(--brutal-border);opacity:.7;text-transform:uppercase;">// SEARCH WIKI</label>
            <input id="nav-search-q" type="text" name="q" placeholder="Search..." value="{{ request('q') }}"
                   style="height:46px;padding:0 14px;border:2px solid var(--brutal-border);background:var(--lab-bg);color:var(--lab-fg);font-family:var(--font-mono);font-size:15px;outline:none;">
            <button type="submit" class="brutal-nav-drawer-link" style="background:var(--brutal-accent);color:#fff;border-color:var(--brutal-border);justify-content:center;">Search →</button>
        </form>
    </x-slot:drawer>
</x-lab::site-nav>

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
