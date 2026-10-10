<x-layouts.public :title="$page->title . ' — Sharzhukov Wiki'">
    <article style="max-width:820px;margin:0 auto;padding:60px 24px;">
        <a href="{{ route('wiki.categories') }}" class="lab-eyebrow" style="display:inline-block;margin-bottom:24px;text-decoration:none;">← Back</a>

        @if($page->category)
            <a href="{{ route('wiki.category', $page->category) }}" class="brutal-badge" style="text-decoration:none;">{{ strtoupper($page->category->name) }}</a>
        @endif

        <h1 class="brutal-hero-title" style="margin:20px 0 16px;font-size:clamp(2rem,4vw,3rem);">{{ $page->title }}</h1>

        <div style="display:flex;gap:16px;align-items:center;margin-bottom:32px;padding-bottom:24px;border-bottom:2px dashed var(--brutal-border);">
            @if($page->author)
                <div style="display:flex;align-items:center;gap:8px;">
                    <img src="{{ $page->author->avatar_url }}" style="width:28px;height:28px;object-fit:cover;border:2px solid var(--brutal-border);">
                    <span style="font-family:var(--font-mono);font-size:12px;font-weight:700;">{{ $page->author->name }}</span>
                </div>
            @endif
            <span class="lab-annotation">Updated {{ $page->updated_at->format('M d, Y') }}</span>
            <span class="lab-annotation">{{ $page->views_count }} views</span>
        </div>

        @if($page->excerpt)
            <p style="font-size:18px;color:var(--lab-fg-muted);line-height:1.6;margin-bottom:32px;font-weight:500;">{{ $page->excerpt }}</p>
        @endif

        <div class="lab-prose">{!! $page->content !!}</div>

        @if($page->tags->isNotEmpty())
            <div style="margin-top:40px;padding-top:24px;border-top:2px dashed var(--brutal-border);display:flex;flex-wrap:wrap;gap:8px;">
                @foreach($page->tags as $tag)
                    <a href="{{ route('wiki.tag', $tag) }}" style="text-decoration:none;">
                        <span style="display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border:2px solid var(--brutal-border);background:var(--lab-bg);font-family:var(--font-mono);font-size:11px;font-weight:700;">
                            @if($tag->color)
                                <span style="display:inline-block;width:6px;height:6px;background:{{ $tag->color }};border:1px solid var(--brutal-border);"></span>
                            @endif
                            #{{ $tag->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </article>

    @if($related->isNotEmpty())
        <section class="brutal-grid-bg" style="padding:60px 24px;border-top:3px solid var(--brutal-border);">
            <div style="max-width:820px;margin:0 auto;">
                <span class="brutal-marker">// RELATED</span>
                <h2 style="font-size:1.5rem;font-weight:800;margin:16px 0 24px;">More from this category</h2>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($related as $rel)
                        <a href="{{ route('wiki.page', $rel) }}" class="brutal-card" style="padding:18px 22px;text-decoration:none;color:inherit;display:flex;justify-content:space-between;align-items:center;gap:16px;">
                            <span style="font-weight:700;">{{ $rel->title }}</span>
                            <span class="lab-annotation">→</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.public>
