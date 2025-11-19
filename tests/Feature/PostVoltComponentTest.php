<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('post edit page can be rendered', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user)
        ->get(route('posts.edit', $post))
        ->assertSuccessful();
});

test('post index page can be rendered', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('posts.index'))
        ->assertSuccessful();
});

test('post create page can be rendered', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('posts.create'))
        ->assertSuccessful();
});

test('authenticated user can access post pages', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user)
        ->get(route('posts.index'))
        ->assertSuccessful();

    $this->actingAs($user)
        ->get(route('posts.create'))
        ->assertSuccessful();

    $this->actingAs($user)
        ->get(route('posts.edit', $post))
        ->assertSuccessful();
});
