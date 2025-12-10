<x-layouts.frontend :title="$post->seo?->meta_title ?? $post->title" :description="$post->seo?->meta_description" :keywords="$post->seo?->keywords" :og-title="$post->seo?->og_title ?? $post->title" :og-description="$post->seo?->og_description ?? $post->seo?->meta_description"
    :og-image="$post->seo?->og_image ?? $post->featured_image" :twitter-card="$post->seo?->twitter_card_type ?? 'summary_large_image'" :twitter-title="$post->seo?->twitter_title ?? ($post->seo?->og_title ?? $post->title)" :twitter-description="$post->seo?->twitter_description ?? $post->seo?->meta_description" :twitter-image="$post->seo?->twitter_image ?? ($post->seo?->og_image ?? $post->featured_image)" :canonical-url="$post->seo?->canonical_url"
    :no-index="$post->seo?->no_index ?? false" :no-follow="$post->seo?->no_follow ?? false">
    <div class="container mx-auto px-6 relative">
        <div class="mb-8">
            <a wire:navigate
                class="inline-flex items-center text-slate-400 hover:text-white transition-colors text-sm font-medium"
                href="{{ route('news.index') }}" data-discover="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-arrow-left w-4 h-4 mr-2" aria-hidden="true">
                    <path d="m12 19-7-7 7-7"></path>
                    <path d="M19 12H5"></path>
                </svg>
                Back to News
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <header class="mb-10 text-center md:text-left">
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">{{ $post->title }}</h1>
                <div class="flex flex-wrap items-center gap-6 text-slate-400 text-sm border-b border-white/10 pb-8">
                </div>
            </header>
            <div
                class="mb-12 rounded-2xl overflow-hidden border border-white/10 shadow-2xl bg-slate-800 aspect-video md:aspect-[21/9] relative">
                <div class="absolute inset-0 bg-gradient-to-t from-[#020617]/50 to-transparent z-10"></div>
                <img alt="{{ $post->title }}" class="w-full h-full object-cover"
                    src="{{ $post->featured_image ? (str_starts_with($post->featured_image, 'http') ? $post->featured_image : Storage::url($post->featured_image)) : asset('backup.png') }}">
            </div>
            <div
                class="prose prose-invert prose-lg max-w-none text-slate-300 mb-16 prose-headings:text-white prose-a:text-cyan-400 prose-li:marker:text-cyan-500">
                {!! $post->content !!}
            </div>
        </div>
    </div>
</x-layouts.frontend>
