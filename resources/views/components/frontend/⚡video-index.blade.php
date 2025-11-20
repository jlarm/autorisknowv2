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
                ->latest()
                ->get();
        });
    }
};
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($this->videos() as $video)
        <article class="bg-white border border-slate-200 rounded-xl overflow-hidden group shadow-sm hover:shadow-lg hover:shadow-slate-200 transition-all">
            {!! $video->styled_embed_code !!}
            <div class="p-4">
                <h3 class="text-slate-900 font-medium mb-1">{{ $video->title }}</h3>
            </div>
        </article>
    @endforeach
</div>
