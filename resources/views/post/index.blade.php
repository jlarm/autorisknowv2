<x-layouts.app :title="__('Posts')">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Posts</flux:heading>
        <flux:button variant="primary" size="sm">Add Post</flux:button>
    </div>
    <flux:separator variant="subtle" class="my-4" />
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative p-3 flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <flux:table class="w-full">
                <flux:table.columns>
                    <flux:table.column>Title</flux:table.column>
                    <flux:table.column>Date</flux:table.column>
                    <flux:table.column></flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    <flux:table.row>
                        <flux:table.cell>Post Title</flux:table.cell>
                        <flux:table.cell>2023-01-01</flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>
        </div>
    </div>
</x-layouts.app>
