<x-layouts.public :title="$category->name . ' — Sharzhukov Wiki'">
    <section class="brutal-grid-bg" style="padding:60px 24px;">
        <div style="max-width:900px;margin:0 auto;">
            <a href="{{ route('wiki.categories') }}" class="lab-eyebrow" style="display:inline-block;margin-bottom:24px;text-decoration:none;">← All categories</a>
            <span class="brutal-marker">// CATEGORY</span>
            <h1 class="brutal-hero-title" style="margin:16px 0 12px;font-size:clamp(2rem,4vw,3rem);">{{ $category->name }}</h1>
            @if($category->description)
                <p style="color:var(--lab-fg-muted);font-size:16px;margin:0 0 40px;max-width:640px;line-height:1.6;">{{ $category->description }}</p>
            @endif

            @if($children->isNotEmpty())
                <h2 style="font-size:1.25rem;font-weight:800;margin:24px 0 16px;">Sub-categories</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;margin-bottom:40px;">
                    @foreach($children as $child)
                        <a href="{{ route('wiki.category', $child) }}" class="brutal-card" style="padding:16px;text-decoration:none;color:inherit;">
                            <div style="display:flex;justify-content:space-between;align-items:center;">
                                <span style="font-weight:700;font-size:15px;">{{ $child->name }}</span>
                                <span class="brutal-badge" style="font-size:10px;">{{ $child->pages_count }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            <h2 style="font-size:1.25rem;font-weight:800;margin:24px 0 16px;">Pages</h2>
            @if($pages->isEmpty())
                <div class="brutal-card" style="text-align:center;padding:40px;">
                    <p style="color:var(--lab-fg-muted);margin:0;">No pages in this category yet.</p>
                </div>
            @else
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($pages as $page)
                        <a href="{{ route('wiki.page', $page) }}" class="brutal-card" style="padding:20px 24px;text-decoration:none;color:inherit;display:flex;justify-content:space-between;align-items:center;gap:16px;">
                            <div style="flex:1;min-width:0;">
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                                    @if($page->is_pinned)
                                        <x-lucide-pin style="width:14px;height:14px;" />
                                    @endif
                                    <span style="font-weight:700;font-size:15px;">{{ $page->title }}</span>
                                </div>
                                @if($page->excerpt)
                                    <p style="color:var(--lab-fg-muted);font-size:13px;margin:0;line-height:1.5;">{{ \Illuminate\Support\Str::limit($page->excerpt, 130) }}</p>
                                @endif
                            </div>
                            <span class="lab-annotation">{{ $page->updated_at->format('Y-m-d') }}</span>
                        </a>
                    @endforeach
                </div>
                <div style="margin-top:24px;">{{ $pages->links() }}</div>
            @endif
        </div>
    </section>
</x-layouts.public>
