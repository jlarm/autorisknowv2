<?php

use App\Models\Video;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {
    #[Validate(['required', 'string', 'min:3', 'max:255'])]
    public string $title = '';
    #[Validate(['required', 'string'])]
    public string $embedCode = '';

    public function save()
    {
        $this->validate();

        $video = Video::create([
            'title' => $this->title,
            'embed_code' => $this->embedCode
        ]);

        Flux::toast(variant: 'success', text: 'Video created successfully');

        $this->redirectRoute('videos.edit', $video);
    }
};
?>

<div>
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Add Video</flux:heading>
    </div>

    <flux:separator variant="subtle" class="my-4"/>

    <div class="relative p-3 flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
        <form wire:submit="save" class="grid grid-cols-3 gap-6">
            <div class="col-span-2 space-y-6">
                <flux:field>
                    <flux:input wire:model="title" type="text" label="Title"/>
                    <flux:error name="title"/>
                </flux:field>

                <flux:field>
                    <flux:textarea label="Embed Link" wire:model="embedCode"/>
                    <flux:error name="title"/>
                </flux:field>

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>

            <div class="col-span-1">

            </div>
        </form>
    </div>
</div>
