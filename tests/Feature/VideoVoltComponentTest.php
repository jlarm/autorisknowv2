<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('video create page can be rendered', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('videos.create'))
        ->assertSuccessful();
});

test('video edit page can be rendered', function (): void {
    $user = User::factory()->create();
    $video = Video::factory()->create();

    $this->actingAs($user)
        ->get(route('videos.edit', $video))
        ->assertSuccessful();
});

test('video index page can be rendered', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('videos.index'))
        ->assertSuccessful();
});

test('authenticated user can access video pages', function (): void {
    $user = User::factory()->create();
    $video = Video::factory()->create();

    $this->actingAs($user)
        ->get(route('videos.index'))
        ->assertSuccessful();

    $this->actingAs($user)
        ->get(route('videos.create'))
        ->assertSuccessful();

    $this->actingAs($user)
        ->get(route('videos.edit', $video))
        ->assertSuccessful();
});
