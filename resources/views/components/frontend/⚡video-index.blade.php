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
                ->latest()
                ->get();
        });
    }
};
?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($this->videos() as $video)
        <article class="w-full">
            {!! $video->styled_embed_code !!}
        </article>
    @endforeach
</div>
