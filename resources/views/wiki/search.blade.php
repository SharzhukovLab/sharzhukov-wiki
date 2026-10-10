<x-layouts.public title="Search — Sharzhukov Wiki">
    <section class="brutal-grid-bg" style="padding:60px 24px;">
        <div style="max-width:900px;margin:0 auto;">
            <span class="brutal-marker">// SEARCH</span>
            <h1 class="brutal-hero-title" style="margin:16px 0 24px;font-size:clamp(1.75rem,3.5vw,2.5rem);">Search</h1>

            <form method="GET" action="{{ route('wiki.search') }}" style="display:flex;gap:0;margin-bottom:40px;">
                <input type="text" name="q" value="{{ $query }}" placeholder="Search documentation..." autofocus style="flex:1;height:48px;padding:0 16px;border:3px solid var(--brutal-border);background:var(--lab-bg);color:var(--lab-fg);font-family:var(--font-mono);font-size:14px;outline:none;">
                <button type="submit" class="lab-btn lab-btn--primary" style="height:48px;padding:0 20px;">SEARCH →</button>
            </form>

            @if(strlen($query) < 2)
                <p style="color:var(--lab-fg-muted);">Enter at least 2 characters to search.</p>
            @elseif($results->isEmpty())
                <div class="brutal-card" style="text-align:center;padding:60px;">
                    <p style="color:var(--lab-fg-muted);margin:0;">No results for "{{ $query }}".</p>
                </div>
            @else
                <p style="color:var(--lab-fg-muted);font-size:14px;margin-bottom:20px;">{{ $results->count() }} {{ \Illuminate\Support\Str::plural('result', $results->count()) }} for "{{ $query }}"</p>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($results as $page)
                        <a href="{{ route('wiki.page', $page) }}" class="brutal-card" style="padding:20px;text-decoration:none;color:inherit;">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                                <span style="font-weight:700;font-size:15px;">{{ $page->title }}</span>
                                @if($page->category)
                                    <span class="brutal-badge" style="font-size:10px;">{{ strtoupper($page->category->name) }}</span>
                                @endif
                            </div>
                            @if($page->excerpt)
                                <p style="color:var(--lab-fg-muted);font-size:13px;margin:0;">{{ \Illuminate\Support\Str::limit($page->excerpt, 150) }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
