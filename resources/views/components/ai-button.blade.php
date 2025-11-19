@props([
    'loadingText' => 'Generating...',
])

<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'flex items-center justify-center px-3 py-1.5 text-sm rounded-lg shadow-lg transition-all duration-300 ease-in-out gap-2 bg-gradient-to-br from-purple-100 border via-white to-blue-100 text-gray-800 shadow-purple-200/50 hover:shadow-purple-300/70 hover:scale-[1.02]'
    ]) }}
>
    <svg
        class="size-3 text-purple-600"
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
    >
        <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"/>
        <path d="M20 2v4"/>
        <path d="M22 4h-4"/>
        <circle cx="4" cy="20" r="2"/>
    </svg>

    @if ($attributes->has('wire:target'))
        <span wire:loading.remove wire:target="{{ $attributes->get('wire:target') }}">
            {{ $slot }}
        </span>
        <span wire:loading wire:target="{{ $attributes->get('wire:target') }}">
            {{ $loadingText }}
        </span>
    @else
        {{ $slot }}
    @endif
</button>
