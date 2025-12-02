<?php

use App\Models\Video;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {
    public Video $video;
    #[Validate(['required', 'string', 'min:3', 'max:255'])]
    public string $title;
    #[Validate(['required', 'string'])]
    public string $embedCode;

    public function mount(): void
    {
        $this->title = $this->video->title;
        $this->embedCode = $this->video->embed_code;
    }

    public function update(): void
    {
        $this->validate();

        $this->video->update([
            'title' => $this->title,
            'embed_code' => $this->embedCode,
        ]);

        \Flux\Flux::toast(variant: 'success', text: 'Video updated successfully');
    }
};
?>

<div>
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Add Video</flux:heading>
    </div>

    <flux:separator variant="subtle" class="my-4" />

    <div class="relative p-3 flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
        <div class="space-y-6">
            <form wire:submit="update" class="space-y-6">
                <flux:field>
                    <flux:input wire:model="title" type="text" label="Title" />
                    <flux:error name="title" />
                </flux:field>

                <flux:field>
                    <flux:textarea label="Embed Link" wire:model="embedCode" />
                    <flux:error name="title" />
                </flux:field>

                <flux:button type="submit" variant="primary">Update</flux:button>
            </form>

            <flux:card>
                <livewire:seo-form :model="$video" :contentField="null" />
            </flux:card>
        </div>
    </div>
</div>
