<x-layouts.frontend
    :title="$post->seo?->meta_title ?? $post->title"
    :description="$post->seo?->meta_description"
    :keywords="$post->seo?->keywords"
    :og-title="$post->seo?->og_title ?? $post->title"
    :og-description="$post->seo?->og_description ?? $post->seo?->meta_description"
    :og-image="$post->seo?->og_image ?? $post->featured_image"
    :twitter-card="$post->seo?->twitter_card_type ?? 'summary_large_image'"
    :twitter-title="$post->seo?->twitter_title ?? $post->seo?->og_title ?? $post->title"
    :twitter-description="$post->seo?->twitter_description ?? $post->seo?->meta_description"
    :twitter-image="$post->seo?->twitter_image ?? $post->seo?->og_image ?? $post->featured_image"
    :canonical-url="$post->seo?->canonical_url"
    :no-index="$post->seo?->no_index ?? false"
    :no-follow="$post->seo?->no_follow ?? false"
>
    <div class="container mx-auto px-6 relative">
        <div class="mb-8">
            <a
                wire:navigate
                class="inline-flex items-center text-slate-400 hover:text-white transition-colors text-sm font-medium"
                href="{{ route('news.index') }}"
                data-discover="true"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left w-4 h-4 mr-2" aria-hidden="true">
                    <path d="m12 19-7-7 7-7"></path>
                    <path d="M19 12H5"></path>
                </svg>
                Back to News
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <header class="mb-10 text-center md:text-left">
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">{{ $post->title }}</h1>
                <div class="flex flex-wrap items-center gap-6 text-slate-400 text-sm border-b border-white/10 pb-8"></div>
            </header>
            <div class="mb-12 rounded-2xl overflow-hidden border border-white/10 shadow-2xl bg-slate-800 aspect-video md:aspect-[21/9] relative">
                <div class="absolute inset-0 bg-gradient-to-t from-[#020617]/50 to-transparent z-10"></div>
                <img alt="{{ $post->title }}" class="w-full h-full object-cover" src="{{ $post->featured_image ? (str_starts_with($post->featured_image, 'http') ? $post->featured_image : Storage::url($post->featured_image)) : asset('backup.png') }}"></div>
                <div class="prose prose-invert prose-lg max-w-none text-slate-300 mb-16 prose-headings:text-white prose-a:text-cyan-400 prose-li:marker:text-cyan-500">
                    {!! $post->content !!}
                </div>
            <div class="border-t border-white/10 pt-10 pb-20 flex flex-col md:flex-row justify-between items-center gap-6"><div class="text-slate-400 font-medium">Share this article</div><div class="flex gap-4"><button class="w-10 h-10 rounded-full bg-[#1e293b] border border-white/10 flex items-center justify-center text-slate-300 hover:bg-cyan-600 hover:text-white hover:border-cyan-500 transition-all"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-linkedin w-4 h-4" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect width="4" height="12" x="2" y="9"></rect><circle cx="4" cy="4" r="2"></circle></svg></button><button class="w-10 h-10 rounded-full bg-[#1e293b] border border-white/10 flex items-center justify-center text-slate-300 hover:bg-cyan-600 hover:text-white hover:border-cyan-500 transition-all"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-twitter w-4 h-4" aria-hidden="true"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg></button><button class="w-10 h-10 rounded-full bg-[#1e293b] border border-white/10 flex items-center justify-center text-slate-300 hover:bg-cyan-600 hover:text-white hover:border-cyan-500 transition-all"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook w-4 h-4" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></button><button class="w-10 h-10 rounded-full bg-[#1e293b] border border-white/10 flex items-center justify-center text-slate-300 hover:bg-cyan-600 hover:text-white hover:border-cyan-500 transition-all"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share2 lucide-share-2 w-4 h-4" aria-hidden="true"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line></svg></button></div></div>
        </div>
    </div>
</x-layouts.frontend>
