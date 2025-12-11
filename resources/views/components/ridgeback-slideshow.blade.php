<div x-data="{
    currentSlide: 0,
    slides: [
        '{{ asset('slides/slide-1.webp') }}',
        '{{ asset('slides/slide-2.webp') }}',
        '{{ asset('slides/slide-3.webp') }}',
        '{{ asset('slides/slide-4.webp') }}',
        '{{ asset('slides/slide-5.webp') }}',
    ],
    init() {
        setInterval(() => {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        }, 4000);
    }
}" class="relative aspect-[4/3] mt-8">
    <template x-for="(slide, index) in slides" :key="index">
        <img :src="slide" :alt="'Slide ' + (index + 1)"
            class="absolute inset-0 object-cover w-full h-full transition-opacity duration-1000 rounded-lg"
            :class="currentSlide === index ? 'opacity-100' : 'opacity-0'" />
    </template>
</div>
