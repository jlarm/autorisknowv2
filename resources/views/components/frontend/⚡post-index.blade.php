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
    public function posts()
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

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($this->posts() as $post)
        <article class="border border-zinc-200 p-4 rounded-lg">
            @if($post->external_link)
                <a href="{{ $post->external_link }}" target="_blank" rel="noopener noreferrer">
                    <img src="{{ $post->featured_image ?: asset('backup.png') }}" alt="{{ $post->title }}"
                         class="w-full h-48 object-cover mb-4 rounded-lg">
                    <h2>{{ $post->title }}</h2>
                </a>
            @else
                <a wire:navigate.hover href="{{ route('post.show', $post) }}">
                    <img src="{{ $post->featured_image ?: asset('backup.png') }}" alt="{{ $post->title }}"
                         class="w-full h-48 object-cover mb-4 rounded-lg">
                    <h2>{{ $post->title }}</h2>
                </a>
            @endif
        </article>
    @endforeach
</div>
