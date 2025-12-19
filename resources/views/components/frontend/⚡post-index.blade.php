<?php

use App\Enums\Status;
use App\Enums\Visibility;
use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function latestPosts(): Collection
    {
        return Cache::remember('posts.latest', now()->addDay(), static function (): Collection {
            return Post::query()
                ->where('status', Status::Published)
                ->where('visibility', Visibility::PUBLIC)
                ->select(['id', 'title', 'slug', 'featured_image', 'external_link'])
                ->latest()
                ->take(4)
                ->get();
        });
    }

    #[Computed]
    public function posts(): Collection
    {
        return Cache::remember('posts.sidebar', now()->addDay(), static function (): Collection {
            return Post::query()
                ->where('status', Status::Published)
                ->where('visibility', Visibility::PUBLIC)
                ->select(['id', 'title', 'slug', 'external_link'])
                ->latest()
                ->skip(4)
                ->take(1000)
                ->get();
        });
    }
};
?>

<div class="flex flex-col lg:flex-row gap-8 items-start">
    <div class="lg:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6 h-full">
        @foreach ($this->latestPosts as $post)
            <article
                class="glass-panel p-6 rounded-xl group cursor-pointer hover:-translate-y-2 transition-all duration-300 shadow-sm hover:shadow-xl hover:shadow-cyan-900/20 border-white/10 bg-[#0f172a]/40 h-full">
                <a href="{{ $post->external_link ?: route('news.show', $post) }}"
                    @if ($post->external_link) target="_blank"
                        rel="noopener noreferrer"
                    @else
                        wire:navigate.hover @endif
                    class="flex flex-col h-full">
                    <div class="h-48 bg-slate-800 rounded-lg mb-4 overflow-hidden border border-white/5">
                        <img src="{{ $post->featured_image ? (str_starts_with($post->featured_image, 'http') ? $post->featured_image : Storage::url($post->featured_image)) : asset('backup.png') }}"
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition-all group-hover:scale-105">
                    </div>
                    <h3 class="text-xl font-bold text-white mt-2 mb-3 group-hover:text-cyan-400 transition-colors">
                        {{ $post->title }}
                    </h3>
                    <div
                        class="flex items-center text-sm text-white font-medium group-hover:text-cyan-400 transition-colors mt-auto">
                        Read Article
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-arrow-right w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform"
                            aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </article>
        @endforeach
    </div>

    <div class="lg:w-1/3 w-full sticky top-28" x-data="{
        isHovered: false,
        animationFrameId: null,
        lastTime: null,
        init() {
            const scroll = (time) => {
                if (!this.isHovered && this.$refs.scrollContainer) {
                    if (this.lastTime === null) {
                        this.lastTime = time;
                    }
    
                    const deltaTime = time - this.lastTime;
                    const scrollSpeed = 0.05; // pixels per millisecond
    
                    this.$refs.scrollContainer.scrollTop += scrollSpeed * deltaTime;
    
                    // Loop check - reset when hitting halfway point
                    const { scrollTop, scrollHeight } = this.$refs.scrollContainer;
                    if (scrollTop >= scrollHeight / 2) {
                        this.$refs.scrollContainer.scrollTop = 0;
                    }
    
                    this.lastTime = time;
                } else if (this.lastTime !== null) {
                    this.lastTime = time;
                }
    
                this.animationFrameId = requestAnimationFrame(scroll);
            };
    
            this.animationFrameId = requestAnimationFrame(scroll);
    
            // Cleanup on component destroy
            this.$watch('animationFrameId', () => {});
        }
    }" @mouseenter="isHovered = true"
        @mouseleave="isHovered = false">
        <div class="relative h-[600px] overflow-hidden border border-white/5 rounded-2xl bg-[#0f172a]/40 group">
            <div
                class="absolute top-0 left-0 right-0 h-20 bg-gradient-to-b from-[#0f172a] via-[#0f172a]/80 to-transparent z-10 pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/80 to-transparent z-10 pointer-events-none">
            </div>
            <div x-ref="scrollContainer"
                class="h-full overflow-y-auto no-scrollbar py-12 px-4 transition-all duration-300">
                @php
                    // Triple the posts for seamless looping
                    $duplicatedPosts = $this->posts->concat($this->posts)->concat($this->posts);
                @endphp
                @foreach ($duplicatedPosts as $post)
                    <a wire:key="post-{{ $post->id }}-{{ $loop->index }}"
                        href="{{ $post->external_link ?: route('news.show', $post) }}"
                        @if ($post->external_link) target="_blank"
                            rel="noopener noreferrer"
                        @else
                            wire:navigate.hover @endif
                        class="block mb-3 p-4 rounded-xl border border-white/5 bg-white/5 hover:bg-[#036482]/20 hover:border-[#036482]/40 transition-all cursor-pointer group/item">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col gap-1 overflow-hidden">
                                <h4
                                    class="text-sm font-semibold text-slate-200 truncate group-hover/item:text-white transition-colors">
                                    {{ $post->title }}</h4>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-chevron-right w-4 h-4 text-slate-600 group-hover/item:text-[#036482] group-hover/item:translate-x-1 transition-all shrink-0"
                                aria-hidden="true">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
