<?php

use App\Models\Video;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    #[Computed]
    public function videos()
    {
        return Video::query()
            ->select(['title', 'embed_code'])
            ->latest()
            ->paginate(12);
    }
};
?>

<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($this->videos as $video)
            <article
                class="bg-[#0f172a]/40 border border-white/10 rounded-xl overflow-hidden group shadow-sm hover:shadow-lg hover:shadow-cyan-900/20 transition-all backdrop-blur-sm">
                {!! $video->styled_embed_code !!}
                <div class="p-4">
                    <h3 class="text-white font-medium">{{ $video->title }}</h3>
                </div>
            </article>
        @endforeach
    </div>

    {{ $this->videos->links('vendor.livewire.dark-tailwind') }}
</div>
