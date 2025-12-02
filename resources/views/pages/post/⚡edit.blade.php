<?php

use App\Enums\Status;
use App\Enums\Visibility;
use App\Livewire\Forms\PostForm;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public PostForm $form;

    public function mount(Post $post): void
    {
        $this->form->setPost($post);
    }

    public function update(): void
    {
        $this->form->update();

        $this->redirect(route('posts.index'));
    }

    public function removeFeaturedImage(): void
    {
        $this->form->featuredImage = null;
    }

    public function render()
    {
        return $this->view()->title($this->form->post->title);
    }
};
?>

<div class="relative p-3 flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    <form wire:submit="update" class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <flux:field>
                <flux:input wire:model="form.title" type="text" placeholder="Title" />
                <flux:error name="title" />
            </flux:field>

            <flux:field>
                <flux:input wire:model="form.slug" type="text" placeholder="Slug" variant="filled" />
                <flux:error name="slug" />
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

            <flux:card>
                <livewire:seo-form :model="$form->post" />
            </flux:card>
        </div>

        <div class="col-span-1 space-y-6">
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
                            @if (is_string($form->featuredImage))
                                <flux:file-item :image="Storage::url($form->featuredImage)">
                                    <x-slot name="actions">
                                        <flux:file-item.remove wire:click="removeFeaturedImage" />
                                    </x-slot>
                                </flux:file-item>
                            @else
                                <flux:file-item :image="$form->featuredImage->temporaryUrl()"
                                    :size="$form->featuredImage->getSize()">
                                    <x-slot name="actions">
                                        <flux:file-item.remove wire:click="removeFeaturedImage" />
                                    </x-slot>
                                </flux:file-item>
                            @endif
                        </div>
                    @endif
                </flux:field>
                <flux:button type="submit" variant="primary" class="w-full">Update</flux:button>
            </flux:card>

            <flux:card>
                <flux:heading size="lg">Search Appearance</flux:heading>
            </flux:card>
        </div>
    </form>
