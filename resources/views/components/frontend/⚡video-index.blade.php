<?php

use App\Models\Video;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function videos()
    {
        return Cache::remember('videos.index', now()->addDay(), static function (): Collection {
            return Video::query()
                ->select(['title', 'embed_code'])
                ->latest(12)
                ->get();
        });
    }
};
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach ($this->videos() as $video)
        <article
            class="bg-[#0f172a]/40 border border-white/10 rounded-xl overflow-hidden group shadow-sm hover:shadow-lg hover:shadow-cyan-900/20 transition-all backdrop-blur-sm">
            {!! $video->styled_embed_code !!}
            <div class="p-4">
                <h3 class="text-white font-medium">{{ $video->title }}</h3>
            </div>
        </article>
    @endforeach
</div>
