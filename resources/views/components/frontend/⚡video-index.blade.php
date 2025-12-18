<?php

use App\Models\Video;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function latestVideos()
    {
        return $this->getVideos()
            ->select(['title', 'embed_code'])
            ->latest()
            ->take(4)
            ->get();
    }

    #[Computed]
    public function videos()
    {
        return $this->getVideos()
            ->latest()
            ->skip(4)
            ->take(1000)
            ->get();
    }

    private function getVideos()
    {
        return Video::query();
    }
};
?>

<div>
    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <div class="lg:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6 h-full">
            @foreach ($this->latestVideos as $video)
                <article
                    class="bg-[#0f172a]/40 border border-white/10 rounded-xl overflow-hidden group shadow-sm hover:shadow-lg hover:shadow-cyan-900/20 transition-all backdrop-blur-sm">
                    {!! $video->styled_embed_code !!}
                    <div class="p-4">
                        <h3 class="text-white font-medium">{{ $video->title }}</h3>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="lg:w-1/3 w-full sticky top-28"
             x-data="{
                isHovered: false,
                animationFrameId: null,
                lastTime: null,
                init() {
                    const scroll = (time) => {
                        if (!this.isHovered && this.$refs.scrollContainer) {
                            if (this.lastTime === null) {
                                this.lastTime = time;
                            }

                            const deltaTime = time - this.lastTime;
                            const scrollSpeed = 0.05; // pixels per millisecond

                            this.$refs.scrollContainer.scrollTop += scrollSpeed * deltaTime;

                            // Loop check - reset when hitting halfway point
                            const { scrollTop, scrollHeight } = this.$refs.scrollContainer;
                            if (scrollTop >= scrollHeight / 2) {
                                this.$refs.scrollContainer.scrollTop = 0;
                            }

                            this.lastTime = time;
                        } else if (this.lastTime !== null) {
                            this.lastTime = time;
                        }

                        this.animationFrameId = requestAnimationFrame(scroll);
                    };

                    this.animationFrameId = requestAnimationFrame(scroll);

                    // Cleanup on component destroy
                    this.$watch('animationFrameId', () => {});
                }
             }"
             @mouseenter="isHovered = true"
             @mouseleave="isHovered = false">
            <div class="relative h-[600px] overflow-hidden border border-white/5 rounded-2xl bg-[#0f172a]/40 group">
                <div class="absolute top-0 left-0 right-0 h-20 bg-gradient-to-b from-[#0f172a] via-[#0f172a]/80 to-transparent z-10 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/80 to-transparent z-10 pointer-events-none"></div>
                <div x-ref="scrollContainer" class="h-full overflow-y-auto no-scrollbar py-12 px-4 transition-all duration-300">
                    @php
                        // Triple the videos for seamless looping
                        $duplicatedVideos = $this->videos->concat($this->videos)->concat($this->videos);
                    @endphp
                    @foreach($duplicatedVideos as $video)
                        <div wire:key="video-{{ $video->id }}-{{ $loop->index }}" class="mb-3 p-4 rounded-xl border border-white/5 bg-white/5 hover:bg-[#036482]/20 hover:border-[#036482]/40 transition-all cursor-pointer group/item flex items-center justify-between">
                            <div class="flex flex-col gap-1 overflow-hidden">
                                <h4 class="text-sm font-semibold text-slate-200 truncate group-hover/item:text-white transition-colors">{{ $video->title }}</h4>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-4 h-4 text-slate-600 group-hover/item:text-[#036482] group-hover/item:translate-x-1 transition-all shrink-0" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
