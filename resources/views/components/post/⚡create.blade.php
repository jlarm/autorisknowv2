<?php

use App\Enums\Status;
use App\Enums\Visibility;
use App\Livewire\Forms\PostForm;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public PostForm $form;

    public function mount(): void
    {
        $this->form->publishedAt = now()->toDateString();
    }

    public function removeFeaturedImage(): void
    {
        if ($this->form->featuredImage) {
            $this->form->featuredImage->delete();
            $this->form->featuredImage = null;
        }
    }

    public function save(): void
    {
        $this->form->save();

        Flux::toast(variant: 'success', text: 'Post created successfully');

        $this->redirect('/posts', navigate: true);
    }
};
?>

<div>
    <form wire:submit="save" class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <flux:field>
                <flux:input wire:model.live="form.title" type="text" placeholder="Title" />
                <flux:error name="title" />
            </flux:field>

            <flux:field>
                <flux:editor wire:model="form.content" />
            </flux:field>

            <flux:card class="space-y-3">
                <flux:heading size="lg">Link to external site</flux:heading>
                <flux:field>
                    <flux:input wire:model="form.externalLink" type="url" placeholder="https://example.com" />
                </flux:field>
            </flux:card>
        </div>

        <div class="col-span-1">
            <flux:card class="space-y-6">
                <flux:field>
                    <flux:select wire:model="form.status" placeholder="Status..." label="Status">
                        @foreach (Status::cases() as $status)
                            <flux:select.option :value="$status">{{ $status->label() }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:select wire:model="form.visibility" placeholder="Visibility..." label="Visibility">
                        @foreach (Visibility::cases() as $visibility)
                            <flux:select.option :value="$visibility">{{ $visibility->label() }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:date-picker label="Publish Date" wire:model="form.publishedAt" />
                </flux:field>

                <flux:field>
                    <flux:file-upload wire:model="form.featuredImage" label="Featured Image">
                        <flux:file-upload.dropzone heading="Drop files here or click to browse"
                            text="JPG, PNG, GIF up to 10MB" />
                    </flux:file-upload>

                    @if ($form->featuredImage)
                        <div class="mt-4 flex flex-col gap-2">
                            <flux:file-item :heading="Str::limit($form->featuredImage->getClientOriginalName(), 40)"
                                :image="$form->featuredImage->temporaryUrl()" :size="$form->featuredImage->getSize()">
                                <x-slot name="actions">
                                    <flux:file-item.remove wire:click="removeFeaturedImage" />
                                </x-slot>
                            </flux:file-item>
                        </div>
                    @endif
                </flux:field>
                <flux:button type="submit" variant="primary" class="w-full">Publish</flux:button>
            </flux:card>
        </div>
    </form>
</div>
