<?php

declare(strict_types=1);

use App\Models\Video;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Videos')]
class extends Component {

    #[Computed]
    public function videos()
    {
        return Video::query()
            ->latest()
            ->get();
    }

};
?>

<div>
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Videos</flux:heading>
        <flux:button wire:navigate href="{{ route('videos.create') }}" variant="primary" size="sm">Add Video
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="my-4"/>

    <flux:table class="w-full">
        <flux:table.columns>
            <flux:table.column>Title</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->videos as $video)
                <flux:table.row>
                    <flux:table.cell>{{ $video->title }}</flux:table.cell>
                    <flux:table.cell align="end">
                        <flux:button wire:navigate href="{{ route('videos.edit', $video) }}" size="sm">Edit</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
