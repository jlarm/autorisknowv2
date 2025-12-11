@props(['title', 'subTitle' => null])
<section class="max-w-4xl mx-auto text-center pt-12 space-y-8">
    <div
        class="flex items-center gap-2 px-4 py-2 rounded-full bg-[#036482]/10 border border-[#036482]/20 text-[#036482] text-xs font-bold uppercase tracking-wider mx-auto w-fit whitespace-nowrap">
        The Risk Partners You Can Trust
    </div>
    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight">
        {{ $title }}
    </h1>
    @if ($subTitle)
        <p class="text-xl text-slate-400 leading-relaxed mb-8">{{ $subTitle }}</p>
    @endif
</section>
