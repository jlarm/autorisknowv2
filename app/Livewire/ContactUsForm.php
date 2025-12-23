<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Contact;
use App\Rules\Turnstile;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class ContactUsForm extends Component
{
    #[Validate(['required', 'string', 'min:3', 'max:255'])]
    public string $name = '';

    #[Validate(['required', 'email', 'min:3', 'max:255'])]
    public string $email = '';

    #[Validate(['required', 'string', 'min:3', 'max:255'])]
    public string $subject = '';

    #[Validate(['required', 'string', 'min:3', 'max:500'])]
    public string $message = '';

    #[Validate(['required', new Turnstile])]
    public string $cfTurnstileResponse = '';

    public bool $submitted = false;

    public function submit(): void
    {
        $this->validate();

        Contact::query()->create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        $this->submitted = true;

        $this->reset(['name', 'email', 'subject', 'message', 'cfTurnstileResponse']);
    }

    public function render(): View
    {
        return view('livewire.contact-us-form');
    }
}
