<?php

use App\Enums\Status;
use App\Enums\Visibility;
use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function posts(): Collection
    {
        return Cache::remember('posts.index', now()->addDay(), static function (): Collection {
            return Post::query()
                ->where('status', Status::Published)
                ->where('visibility', Visibility::PUBLIC)
                ->select(['id', 'title', 'slug', 'featured_image', 'external_link'])
                ->latest()
                ->get();
        });
    }
};
?>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($this->posts as $post)
        <article class="glass-panel p-6 rounded-xl group cursor-pointer hover:-translate-y-2 transition-all duration-300 shadow-sm hover:shadow-xl hover:shadow-cyan-900/20 border-white/10 bg-[#0f172a]/40 h-full">
            <a
                href="{{ $post->external_link ?: route('news.show', $post) }}"
                @if($post->external_link)
                    target="_blank"
                    rel="noopener noreferrer"
                @else
                    wire:navigate.hover
                @endif
                class="flex flex-col h-full"
            >
                <div class="h-48 bg-slate-800 rounded-lg mb-4 overflow-hidden border border-white/5">
                    <img
                        src="{{ $post->featured_image ? (str_starts_with($post->featured_image, 'http') ? $post->featured_image : Storage::url($post->featured_image)) : asset('backup.png') }}"
                        alt="{{ $post->title }}"
                        class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition-all group-hover:scale-105"
                    >
                </div>
                <h3 class="text-xl font-bold text-white mt-2 mb-3 group-hover:text-cyan-400 transition-colors">
                    {{ $post->title }}
                </h3>
                <div class="flex items-center text-sm text-white font-medium group-hover:text-cyan-400 transition-colors mt-auto">
                    Read Article
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </div>
            </a>
        </article>
    @endforeach
</div>
