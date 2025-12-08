<?php

use App\Models\Contact;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    #[Computed]
    public function submissions()
    {
        return Contact::query()->latest()->paginate(25);
    }
};
?>

<div>
    <flux:table :paginate="$this->submissions">
        <flux:table.columns>
            <flux:table.column>Date</flux:table.column>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Email</flux:table.column>
            <flux:table.column>Subject</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->submissions as $submission)
                <flux:table.row>
                    <flux:table.cell>{{ $submission->created_at->format('m/d/Y') }}</flux:table.cell>
                    <flux:table.cell>{{ $submission->name }}</flux:table.cell>
                    <flux:table.cell>{{ $submission->email }}</flux:table.cell>
                    <flux:table.cell>{{ $submission->subject }}</flux:table.cell>
                    <flux:table.cell class="flex justify-end">
                        <flux:modal.trigger :name="'view-message-'.$submission->id">
                            <flux:button class="ml-auto" size="xs">View</flux:button>
                        </flux:modal.trigger>

                        <flux:modal :name="'view-message-'.$submission->id" class="md:w-96">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">{{ $submission->name }}</flux:heading>
                                    <flux:text class="mt-2">{{ $submission->created_at->format('m/d/Y') }}</flux:text>
                                </div>

                                <div>
                                    <flux:heading>{{ $submission->subject }}</flux:heading>
                                    <flux:text class="mt-2">{{ $submission->message }}</flux:text>
                                </div>
                            </div>
                        </flux:modal>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
