<x-layouts.public :title="'#' . $tag->name . ' — Sharzhukov Wiki'">
    <section class="brutal-grid-bg" style="padding:60px 24px;">
        <div style="max-width:900px;margin:0 auto;">
            <a href="{{ route('wiki.tags') }}" class="lab-eyebrow" style="display:inline-block;margin-bottom:24px;text-decoration:none;">← All tags</a>
            <span class="brutal-marker">// TAG</span>
            <h1 class="brutal-hero-title" style="margin:16px 0 32px;font-size:clamp(2rem,4vw,3rem);">#{{ $tag->name }}</h1>
            @if($pages->isEmpty())
                <div class="brutal-card" style="text-align:center;padding:60px;">
                    <p style="color:var(--lab-fg-muted);margin:0;">No pages with this tag yet.</p>
                </div>
            @else
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($pages as $page)
                        <a href="{{ route('wiki.page', $page) }}" class="brutal-card" style="padding:18px 22px;text-decoration:none;color:inherit;">
                            <div style="font-weight:700;margin-bottom:4px;">{{ $page->title }}</div>
                            @if($page->excerpt)
                                <p style="color:var(--lab-fg-muted);font-size:13px;margin:0;">{{ \Illuminate\Support\Str::limit($page->excerpt, 130) }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
                <div style="margin-top:24px;">{{ $pages->links() }}</div>
            @endif
        </div>
    </section>
</x-layouts.public>
