<?php

declare(strict_types=1);

use App\Livewire\ContactUsForm;
use App\Models\Contact;
use App\Rules\Turnstile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Volt\Volt;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    // Mock Cloudflare Turnstile API response
    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
            'success' => true,
        ], 200),
    ]);
});

test('contact form submits successfully with valid data', function (): void {
    Volt::test(ContactUsForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message')
        ->set('cfTurnstileResponse', 'test-turnstile-token')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    expect(Contact::query()->count())->toBe(1);

    $contact = Contact::query()->first();
    expect($contact->name)->toBe('John Doe')
        ->and($contact->email)->toBe('john@example.com')
        ->and($contact->subject)->toBe('Test Subject')
        ->and($contact->message)->toBe('This is a test message');
});

test('contact form validates required fields', function (): void {
    Volt::test(ContactUsForm::class)
        ->set('name', '')
        ->set('email', '')
        ->set('subject', '')
        ->set('message', '')
        ->set('cfTurnstileResponse', '')
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'subject', 'message', 'cfTurnstileResponse']);

    expect(Contact::query()->count())->toBe(0);
});

test('contact form validates minimum length', function (): void {
    Volt::test(ContactUsForm::class)
        ->set('name', 'ab')
        ->set('email', 'ab')
        ->set('subject', 'ab')
        ->set('message', 'ab')
        ->set('cfTurnstileResponse', 'test-turnstile-token')
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'subject', 'message']);

    expect(Contact::query()->count())->toBe(0);
});

test('contact form validates maximum length for name', function (): void {
    Volt::test(ContactUsForm::class)
        ->set('name', str_repeat('a', 256))
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'Test message')
        ->set('cfTurnstileResponse', 'test-turnstile-token')
        ->call('submit')
        ->assertHasErrors(['name']);

    expect(Contact::query()->count())->toBe(0);
});

test('contact form validates maximum length for message at 500 characters', function (): void {
    Volt::test(ContactUsForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', str_repeat('a', 501))
        ->set('cfTurnstileResponse', 'test-turnstile-token')
        ->call('submit')
        ->assertHasErrors(['message']);

    expect(Contact::query()->count())->toBe(0);
});

test('contact form accepts message with exactly 500 characters', function (): void {
    $message = str_repeat('a', 500);

    Volt::test(ContactUsForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', $message)
        ->set('cfTurnstileResponse', 'test-turnstile-token')
        ->call('submit')
        ->assertHasNoErrors();

    expect(Contact::query()->count())->toBe(1);
    expect(Contact::query()->first()->message)->toBe($message);
});

test('contact form resets fields after successful submission', function (): void {
    Volt::test(ContactUsForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message')
        ->set('cfTurnstileResponse', 'test-turnstile-token')
        ->call('submit')
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('subject', '')
        ->assertSet('message', '')
        ->assertSet('cfTurnstileResponse', '');
});

test('contact form validates string type for all fields', function (): void {
    Volt::test(ContactUsForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message')
        ->set('cfTurnstileResponse', 'test-turnstile-token')
        ->call('submit')
        ->assertHasNoErrors();

    expect(Contact::query()->count())->toBe(1);
});
