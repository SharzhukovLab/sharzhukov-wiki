<x-layouts.public title="Sharzhukov Wiki — Documentation">
    {{-- HERO --}}
    <section class="brutal-grid-bg" style="padding:80px 24px 60px;border-bottom:3px solid var(--brutal-border);">
        <div style="max-width:1100px;margin:0 auto;text-align:center;">
            <span class="brutal-marker">// WIKI</span>
            <h1 class="brutal-hero-title" style="margin:24px 0 20px;">
                Documentation.<br>
                <span style="background:var(--brutal-accent);color:#fff;padding:0 .12em;box-shadow:6px 6px 0 var(--brutal-shadow);display:inline-block;transform:rotate(-1deg);">Knowledge.</span>
            </h1>
            <p style="color:var(--lab-fg-muted);font-size:17px;max-width:560px;margin:0 auto 32px;line-height:1.6;">
                Guides, references, and internal notes for our projects.
            </p>
            <form method="GET" action="{{ route('wiki.search') }}" style="max-width:480px;margin:0 auto;display:flex;gap:0;">
                <input type="text" name="q" placeholder="Search documentation..." style="flex:1;height:48px;padding:0 16px;border:3px solid var(--brutal-border);background:var(--lab-bg);color:var(--lab-fg);font-family:var(--font-mono);font-size:14px;outline:none;">
                <button type="submit" class="lab-btn lab-btn--primary" style="height:48px;padding:0 20px;">SEARCH →</button>
            </form>
        </div>
    </section>

    {{-- PINNED --}}
    @if($pinnedPages->isNotEmpty())
        <section class="brutal-grid-bg" style="padding:60px 24px;border-bottom:3px solid var(--brutal-border);">
            <div style="max-width:1100px;margin:0 auto;">
                <span class="brutal-marker">// PINNED</span>
                <h2 style="font-family:var(--font-sans);font-weight:900;font-size:2rem;letter-spacing:-0.03em;margin:16px 0 32px;line-height:1;">Start here</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;">
                    @foreach($pinnedPages as $page)
                        <a href="{{ route('wiki.page', $page) }}" class="brutal-card" style="padding:24px;">
                            <span class="brutal-badge brutal-badge--orange" style="font-size:10px;">PINNED</span>
                            <h3 style="margin:14px 0 8px;font-size:18px;font-weight:800;">{{ $page->title }}</h3>
                            @if($page->excerpt)
                                <p style="color:var(--lab-fg-muted);font-size:13px;margin:0;line-height:1.55;">{{ $page->excerpt }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CATEGORIES --}}
    <section class="brutal-grid-bg" style="padding:60px 24px;border-bottom:3px solid var(--brutal-border);">
        <div style="max-width:1100px;margin:0 auto;">
            <span class="brutal-marker">// CATEGORIES</span>
            <h2 style="font-family:var(--font-sans);font-weight:900;font-size:2rem;letter-spacing:-0.03em;margin:16px 0 32px;line-height:1;">Browse by topic</h2>
            @if($categories->isEmpty())
                <div class="brutal-card" style="text-align:center;padding:60px;">
                    <p style="color:var(--lab-fg-muted);margin:0;font-weight:600;">No categories yet.</p>
                </div>
            @else
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px;">
                    @foreach($categories as $cat)
                        <a href="{{ route('wiki.category', $cat) }}" class="brutal-card" style="padding:24px;display:flex;flex-direction:column;gap:12px;">
                            <div style="display:flex;justify-content:space-between;align-items:center;">
                                <x-lucide-folder-open style="width:28px;height:28px;" />
                                <span class="brutal-badge">{{ $cat->pages_count }} {{ \Illuminate\Support\Str::plural('page', $cat->pages_count) }}</span>
                            </div>
                            <h3 style="margin:0;font-size:18px;font-weight:800;letter-spacing:-0.01em;">{{ $cat->name }}</h3>
                            @if($cat->description)
                                <p style="color:var(--lab-fg-muted);font-size:13px;margin:0;line-height:1.55;">{{ $cat->description }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- RECENT --}}
    @if($recentPages->isNotEmpty())
        <section class="brutal-grid-bg" style="padding:60px 24px;border-bottom:3px solid var(--brutal-border);">
            <div style="max-width:1100px;margin:0 auto;">
                <span class="brutal-marker">// RECENT</span>
                <h2 style="font-family:var(--font-sans);font-weight:900;font-size:2rem;letter-spacing:-0.03em;margin:16px 0 32px;line-height:1;">Recently updated</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:16px;">
                    @foreach($recentPages as $page)
                        <a href="{{ route('wiki.page', $page) }}" class="brutal-card" style="padding:20px;">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                                @if($page->category)
                                    <span class="brutal-badge" style="font-size:10px;">{{ strtoupper($page->category->name) }}</span>
                                @endif
                                <span class="lab-annotation">{{ $page->updated_at->diffForHumans() }}</span>
                            </div>
                            <h3 style="margin:0 0 6px;font-size:16px;font-weight:700;">{{ $page->title }}</h3>
                            @if($page->excerpt)
                                <p style="color:var(--lab-fg-muted);font-size:13px;margin:0;line-height:1.5;">{{ \Illuminate\Support\Str::limit($page->excerpt, 100) }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- TAGS --}}
    @if($tags->isNotEmpty())
        <section class="brutal-grid-bg" style="padding:60px 24px;">
            <div style="max-width:1100px;margin:0 auto;">
                <span class="brutal-marker">// TAGS</span>
                <h2 style="font-family:var(--font-sans);font-weight:900;font-size:2rem;letter-spacing:-0.03em;margin:16px 0 32px;line-height:1;">Popular tags</h2>
                <div style="display:flex;flex-wrap:wrap;gap:10px;">
                    @foreach($tags as $tag)
                        <a href="{{ route('wiki.tag', $tag) }}" style="text-decoration:none;">
                            <span style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border:2px solid var(--brutal-border);background:var(--lab-bg);font-family:var(--font-mono);font-size:12px;font-weight:700;box-shadow:3px 3px 0 var(--brutal-shadow);">
                                @if($tag->color)
                                    <span style="display:inline-block;width:8px;height:8px;background:{{ $tag->color }};border:1px solid var(--brutal-border);"></span>
                                @endif
                                {{ $tag->name }}
                                <span style="opacity:.5;">{{ $tag->pages_count }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.public>
