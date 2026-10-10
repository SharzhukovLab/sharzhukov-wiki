<x-layouts.public title="Tags — Sharzhukov Wiki">
    <section class="brutal-grid-bg" style="padding:60px 24px;">
        <div style="max-width:900px;margin:0 auto;">
            <span class="brutal-marker">// TAGS</span>
            <h1 class="brutal-hero-title" style="margin:16px 0 32px;font-size:clamp(2rem,4vw,3rem);">All tags</h1>
            @if($tags->isEmpty())
                <div class="brutal-card" style="text-align:center;padding:60px;">
                    <p style="color:var(--lab-fg-muted);margin:0;">No tags yet.</p>
                </div>
            @else
                <div style="display:flex;flex-wrap:wrap;gap:10px;">
                    @foreach($tags as $tag)
                        <a href="{{ route('wiki.tag', $tag) }}" style="text-decoration:none;">
                            <span style="display:inline-flex;align-items:center;gap:6px;padding:10px 16px;border:2px solid var(--brutal-border);background:var(--lab-bg);font-family:var(--font-mono);font-size:13px;font-weight:700;box-shadow:3px 3px 0 var(--brutal-shadow);">
                                @if($tag->color)
                                    <span style="display:inline-block;width:8px;height:8px;background:{{ $tag->color }};border:1px solid var(--brutal-border);"></span>
                                @endif
                                #{{ $tag->name }}
                                <span style="opacity:.5;">{{ $tag->pages_count }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
