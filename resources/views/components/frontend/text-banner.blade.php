<div class="relative overflow-hidden w-full bg-zinc-100 py-32">
    <div class="max-w-2xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <img class="absolute w-[500px] top-6 right-3 opacity-40 animate-[slideInFromRight_0.3s_ease-out]"
            src="{{ asset('banner-hero.webp') }}" alt="">
        <h1 class="text-5xl font-medium leading-14 animate-[fadeIn_0.6s_ease-out]">{{ $title }}</h1>
        <p class="mt-5 animate-[fadeIn_0.6s_ease-out_0.2s_both]">{{ $slot }}</p>
    </div>
</div>
