<x-layouts.app :title="__('Create Post')">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Create Post</flux:heading>
    </div>
    <flux:separator variant="subtle" class="my-4" />
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative p-3 flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <livewire:post.create />
        </div>
    </div>
</x-layouts.app>
