<?php

declare(strict_types=1);

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Videos')]
class extends Component
{
    //
};
?>

<div>
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Videos</flux:heading>
        <flux:button wire:navigate href="{{ route('videos.create') }}" variant="primary" size="sm">Add Video</flux:button>
    </div>

    <flux:separator variant="subtle" class="my-4" />

    <div></div>
</div>
