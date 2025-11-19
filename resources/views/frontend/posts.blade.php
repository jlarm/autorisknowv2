<x-layouts.frontend title="News">
    <x-frontend.text-banner>
        <x-slot:title>Explore our latest articles <span class="block text-zinc-400">about tech industries</span></x-slot:title>
        Explore our latest articles, whitepapers, and thought leadership content, unlocking valuable insights and best practices to fortify your digital assets.
    </x-frontend.text-banner>
    <div class="max-w-7xl mx-auto mt-32">
        <livewire:frontend.post-index lazy />
    </div>
</x-layouts.frontend>
