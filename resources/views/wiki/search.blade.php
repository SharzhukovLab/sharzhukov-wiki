<x-layouts.public :title="'Search — ' . ($query ?: 'Wiki') . ' — Sharzhukov Wiki'">
    @push('meta')
        <meta name="robots" content="noindex, follow">
    @endpush

    <section class="brutal-grid-bg" style="padding:60px 24px 32px;border-bottom:3px solid var(--brutal-border);">
        <div style="max-width:900px;margin:0 auto;">
            <span class="brutal-marker">// SEARCH</span>
            <h1 class="brutal-hero-title" style="margin:16px 0 20px;font-size:clamp(2rem,4vw,3rem);">
                Search the wiki
            </h1>

            <form method="GET" action="{{ url('/search') }}" style="display:flex;gap:10px;flex-wrap:wrap;">
                <input type="text" name="q" value="{{ $query }}"
                       placeholder="Type at least 2 characters…"
                       autofocus
                       style="flex:1;min-width:220px;height:48px;padding:0 16px;border:2px solid var(--brutal-border);background:var(--lab-bg);color:var(--lab-fg);font-family:var(--font-mono);font-size:14px;outline:none;">
                <button type="submit" class="lab-btn lab-btn--primary" style="height:48px;">Search →</button>
            </form>

            @if(mb_strlen($query) >= 2)
                <p style="font-family:var(--font-mono);font-size:13px;color:var(--lab-fg-muted);margin:20px 0 0;">
                    // {{ $results->count() }} {{ \Illuminate\Support\Str::plural('result', $results->count()) }} for "{{ $query }}"
                </p>
            @endif
        </div>
    </section>

    <article style="max-width:900px;margin:0 auto;padding:40px 24px 80px;">
        @if(mb_strlen($query) < 2)
            <div class="brutal-card" style="padding:40px;text-align:center;">
                <p style="color:var(--lab-fg-muted);font-size:15px;margin:0;">Enter a query (2+ characters) to search the wiki.</p>
            </div>
        @elseif($results->isEmpty())
            <div class="brutal-card" style="padding:48px;text-align:center;">
                <p style="color:var(--lab-fg-muted);font-size:15px;margin:0 0 16px;">No results for <strong>"{{ $query }}"</strong>.</p>
                <p style="color:var(--lab-fg-muted);font-size:13px;margin:0;">
                    Try shorter keyword or browse <a href="{{ url('/pages') }}">all pages</a>.
                </p>
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:14px;">
                @foreach($results as $page)
                    <a href="{{ route('wiki.page', $page) }}" style="text-decoration:none;color:inherit;display:block;">
                        <div class="brutal-card" style="padding:22px;transition:transform .12s ease, box-shadow .12s ease;">
                            @if($page->category)
                                <div style="font-family:var(--font-mono);font-size:10px;letter-spacing:0.12em;color:var(--brutal-accent);font-weight:700;text-transform:uppercase;margin-bottom:8px;">
                                    // {{ $page->category->name }}
                                </div>
                            @endif
                            <h2 style="margin:0 0 8px;font-family:var(--font-sans);font-weight:900;font-size:19px;letter-spacing:-0.01em;line-height:1.25;">
                                {!! $page->_title_html ?? e($page->title) !!}
                            </h2>
                            @if(!empty($page->_snippet_html))
                                <p style="margin:0;color:var(--lab-fg-muted);font-size:14px;line-height:1.6;">
                                    {!! $page->_snippet_html !!}
                                </p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </article>
</x-layouts.public>

<style>
    mark {
        background: var(--brutal-accent);
        color: #fff;
        padding: 0 3px;
    }
    .brutal-card a:hover, a:hover .brutal-card {
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0 var(--brutal-shadow);
    }
</style>