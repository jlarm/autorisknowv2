<x-layouts.app :title="__('Posts')">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Posts</flux:heading>
        <flux:button wire:navigate href="{{ route('posts.create') }}" variant="primary" size="sm">Add Post
        </flux:button>
    </div>
    <flux:separator variant="subtle" class="my-4" />
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative p-3 flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <livewire:post.index />
        </div>
    </div>
</x-layouts.app>
