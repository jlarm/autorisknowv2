<x-layouts.frontend title="News">
    <x-frontend.text-banner>
        <x-slot:title>{{ $post->title }}</x-slot:title>
        {{ $post->created_at->format('F d, Y') }}
    </x-frontend.text-banner>
    <div class="max-w-3xl mx-auto mt-32">
        <div class="prose dark:prose-invert">
            {!! $post->content !!}
        </div>
    </div>
</x-layouts.frontend>
