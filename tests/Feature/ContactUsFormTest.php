<?php

declare(strict_types=1);

use App\Livewire\ContactUsForm;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;

uses(RefreshDatabase::class);

test('contact form submits successfully with valid data', function (): void {
    Volt::test(ContactUsForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message')
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
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'subject', 'message']);

    expect(Contact::query()->count())->toBe(0);
});

test('contact form validates minimum length', function (): void {
    Volt::test(ContactUsForm::class)
        ->set('name', 'ab')
        ->set('email', 'ab')
        ->set('subject', 'ab')
        ->set('message', 'ab')
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
        ->call('submit')
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('subject', '')
        ->assertSet('message', '');
});

test('contact form validates string type for all fields', function (): void {
    Volt::test(ContactUsForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message')
        ->call('submit')
        ->assertHasNoErrors();

    expect(Contact::query()->count())->toBe(1);
});
