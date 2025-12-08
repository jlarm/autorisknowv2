<x-layouts.app :title="__('Contact Form Submissions')">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Form Submissions</flux:heading>
    </div>

    <flux:separator variant="subtle" class="my-4" />

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <livewire:contact.index />
    </div>
</x-layouts.app>
