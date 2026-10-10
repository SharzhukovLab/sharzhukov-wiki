<x-layouts.public title="Categories — Sharzhukov Wiki">
    <section class="brutal-grid-bg" style="padding:60px 24px;">
        <div style="max-width:1100px;margin:0 auto;">
            <span class="brutal-marker">// CATEGORIES</span>
            <h1 class="brutal-hero-title" style="margin:16px 0 32px;font-size:clamp(2rem,4vw,3rem);">All categories</h1>
            @if($categories->isEmpty())
                <div class="brutal-card" style="text-align:center;padding:60px;">
                    <p style="color:var(--lab-fg-muted);margin:0;font-weight:600;">No categories yet.</p>
                </div>
            @else
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;">
                    @foreach($categories as $cat)
                        <div class="brutal-card" style="padding:24px;">
                            <a href="{{ route('wiki.category', $cat) }}" style="text-decoration:none;color:inherit;display:block;">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                                    <x-lucide-folder-open style="width:26px;height:26px;" />
                                    <span class="brutal-badge">{{ $cat->pages_count }}</span>
                                </div>
                                <h3 style="margin:0 0 6px;font-size:18px;font-weight:800;">{{ $cat->name }}</h3>
                                @if($cat->description)
                                    <p style="color:var(--lab-fg-muted);font-size:13px;margin:0;">{{ $cat->description }}</p>
                                @endif
                            </a>
                            @if($cat->children->isNotEmpty())
                                <ul style="list-style:none;padding:12px 0 0;margin:12px 0 0;border-top:2px dashed var(--brutal-border);display:flex;flex-direction:column;gap:6px;">
                                    @foreach($cat->children as $child)
                                        <li>
                                            <a href="{{ route('wiki.category', $child) }}" style="font-size:13px;color:var(--lab-fg-muted);text-decoration:none;font-weight:600;">→ {{ $child->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
