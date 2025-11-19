<?php

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function posts()
    {
        return Post::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(20);
    }
};
?>

<div>
    <flux:table class="w-full" :paginate="$this->posts">
        <flux:table.columns>
            <flux:table.column class="w-3/5" sortable :sorted="$sortBy === 'title'" :direction="$sortDirection" wire:click="sort('title')">Title</flux:table.column>
            <flux:table.column class="w-1/5" sortable :sorted="$sortBy === 'published_at'" :direction="$sortDirection" wire:click="sort('published_at')">Published</flux:table.column>
            <flux:table.column class="w-1/5">Status</flux:table.column>
            <flux:table.column class="w-1/5">Visibility</flux:table.column>
            <flux:table.column class="w-1/5"></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($this->posts as $post)
                <flux:table.row>
                    <flux:table.cell class="w-3/5">
                        <a wire:navigate href="{{ route('posts.edit', $post) }}" class="flex items-center gap-2">
                            <span class="hover:underline">{{ Str::limit($post->title, 50) }}</span>
                            @if($post->external_link)
                                <flux:badge size="sm" color="blue" inset="top bottom">External Link</flux:badge>
                            @endif
                        </a>
                    </flux:table.cell>
                    <flux:table.cell class="w-1/5">{{ $post->published_at->format('M d, Y') }}</flux:table.cell>
                    <flux:table.cell class="w-1/5">
                        <flux:badge size="sm" :color="$post->status->color()" inset="top bottom">{{ $post->status->label() }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell class="w-1/5">
                        <flux:badge size="sm" :color="$post->visibility->color()" inset="top bottom">{{ $post->visibility->label() }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell class="w-1/5" align="end">
                        <flux:button wire:navigate :href="route('posts.edit', $post)" size="sm">Edit</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
