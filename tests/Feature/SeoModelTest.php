<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\Seo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create seo with twitter card fields', function () {
    $post = Post::factory()->create();

    $seo = Seo::factory()->create([
        'seoable_type' => Post::class,
        'seoable_id' => $post->id,
        'twitter_card' => 'summary_large_image',
        'twitter_title' => 'Test Twitter Title',
        'twitter_description' => 'Test Twitter Description',
        'twitter_image' => 'https://example.com/image.jpg',
        'twitter_site' => '@example',
        'twitter_creator' => '@johndoe',
    ]);

    expect($seo->twitter_card)->toBe('summary_large_image');
    expect($seo->twitter_title)->toBe('Test Twitter Title');
    expect($seo->twitter_description)->toBe('Test Twitter Description');
    expect($seo->twitter_image)->toBe('https://example.com/image.jpg');
    expect($seo->twitter_site)->toBe('@example');
    expect($seo->twitter_creator)->toBe('@johndoe');
});

test('seo belongs to seoable model', function () {
    $post = Post::factory()->create();
    $seo = Seo::factory()->create([
        'seoable_type' => Post::class,
        'seoable_id' => $post->id,
    ]);

    expect($seo->seoable)->toBeInstanceOf(Post::class);
    expect($seo->seoable->id)->toBe($post->id);
});

test('twitter card type accessor returns default value', function () {
    $seo = Seo::factory()->create([
        'seoable_type' => Post::class,
        'seoable_id' => Post::factory()->create()->id,
        'twitter_card' => null,
    ]);

    expect($seo->twitterCardType)->toBe('summary_large_image');
});

test('twitter card type accessor returns actual value when set', function () {
    $seo = Seo::factory()->create([
        'seoable_type' => Post::class,
        'seoable_id' => Post::factory()->create()->id,
        'twitter_card' => 'summary',
    ]);

    expect($seo->twitterCardType)->toBe('summary');
});

test('keywords are cast to array', function () {
    $post = Post::factory()->create();
    $seo = Seo::factory()->create([
        'seoable_type' => Post::class,
        'seoable_id' => $post->id,
        'keywords' => ['laravel', 'seo', 'twitter'],
    ]);

    expect($seo->keywords)->toBeArray();
    expect($seo->keywords)->toContain('laravel', 'seo', 'twitter');
});

test('no_index and no_follow are cast to boolean', function () {
    $post = Post::factory()->create();
    $seo = Seo::factory()->create([
        'seoable_type' => Post::class,
        'seoable_id' => $post->id,
        'no_index' => true,
        'no_follow' => false,
    ]);

    expect($seo->no_index)->toBeBool()->toBeTrue();
    expect($seo->no_follow)->toBeBool()->toBeFalse();
});
