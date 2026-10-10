<x-layouts.public title="All pages — Sharzhukov Wiki">
    <section class="brutal-grid-bg" style="padding:60px 24px;">
        <div style="max-width:900px;margin:0 auto;">
            <span class="brutal-marker">// ALL PAGES</span>
            <h1 class="brutal-hero-title" style="margin:16px 0 32px;font-size:clamp(2rem,4vw,3rem);">Every page</h1>
            @if($pages->isEmpty())
                <div class="brutal-card" style="text-align:center;padding:60px;">
                    <p style="color:var(--lab-fg-muted);margin:0;">No pages yet.</p>
                </div>
            @else
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($pages as $page)
                        <a href="{{ route('wiki.page', $page) }}" class="brutal-card" style="padding:18px 22px;text-decoration:none;color:inherit;display:flex;justify-content:space-between;align-items:center;gap:16px;">
                            <div>
                                <div style="font-weight:700;font-size:15px;">{{ $page->title }}</div>
                                @if($page->category)
                                    <span class="lab-annotation">{{ strtoupper($page->category->name) }}</span>
                                @endif
                            </div>
                            <span class="lab-annotation">{{ $page->updated_at->format('M d, Y') }}</span>
                        </a>
                    @endforeach
                </div>
                <div style="margin-top:24px;">{{ $pages->links() }}</div>
            @endif
        </div>
    </section>
</x-layouts.public>
