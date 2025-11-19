<?php

declare(strict_types=1);

use App\Enums\Status;
use App\Enums\Visibility;
use App\Models\Post;
use App\Models\Seo;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create a post with factory', function (): void {
    $post = Post::factory()->create();

    expect($post)->toBeInstanceOf(Post::class);
    expect($post->id)->toBeInt();
    expect($post->title)->toBeString()->not->toBeEmpty();
    expect($post->slug)->toBeString()->not->toBeEmpty();
    expect($post->content)->toBeString()->not->toBeEmpty();
    expect($post->featured_image)->toBeString();
});

test('post has correct casts', function (): void {
    $post = Post::factory()->create([
        'status' => 'published',
        'visibility' => 'public',
        'published_at' => '2024-01-15',
    ]);

    expect($post->status)->toBeInstanceOf(Status::class);
    expect($post->visibility)->toBeInstanceOf(Visibility::class);
    expect($post->published_at)->toBeInstanceOf(Carbon::class);
    expect($post->created_at)->toBeInstanceOf(Carbon::class);
    expect($post->updated_at)->toBeInstanceOf(Carbon::class);
});

test('post status enum works correctly', function (): void {
    $publishedPost = Post::factory()->create(['status' => 'published']);
    $draftPost = Post::factory()->create(['status' => 'draft']);

    expect($publishedPost->status)->toBe(Status::Published);
    expect($draftPost->status)->toBe(Status::Draft);
});

test('post visibility enum works correctly', function (): void {
    $publicPost = Post::factory()->create(['visibility' => 'public']);
    $privatePost = Post::factory()->create(['visibility' => 'private']);

    expect($publicPost->visibility)->toBe(Visibility::PUBLIC);
    expect($privatePost->visibility)->toBe(Visibility::PRIVATE);
});

test('post has seo relationship', function (): void {
    $post = Post::factory()->create();
    $seo = Seo::factory()->create([
        'seoable_type' => Post::class,
        'seoable_id' => $post->id,
    ]);

    expect($post->seo)->toBeInstanceOf(Seo::class);
    expect($post->seo->id)->toBe($seo->id);
});

test('post seo relationship returns null when no seo exists', function (): void {
    $post = Post::factory()->create();

    expect($post->seo)->toBeNull();
});

test('can create post with external link', function (): void {
    $externalLink = 'https://example.com/article';
    $post = Post::factory()->create([
        'external_link' => $externalLink,
    ]);

    expect($post->external_link)->toBe($externalLink);
});

test('post can be created without external link', function (): void {
    $post = Post::factory()->create([
        'external_link' => null,
    ]);

    expect($post->external_link)->toBeNull();
});

test('post factory generates unique title and slug', function (): void {
    $post1 = Post::factory()->create();
    $post2 = Post::factory()->create();

    expect($post1->title)->not->toBe($post2->title);
    expect($post1->slug)->not->toBe($post2->slug);
});

test('post can be updated', function (): void {
    $post = Post::factory()->create(['title' => 'Original Title']);

    $post->update(['title' => 'Updated Title']);

    expect($post->fresh()->title)->toBe('Updated Title');
});

test('post can be deleted', function (): void {
    $post = Post::factory()->create();
    $postId = $post->id;

    $post->delete();

    expect(Post::query()->find($postId))->toBeNull();
});

test('multiple posts can be created', function (): void {
    $posts = Post::factory()->count(5)->create();

    expect($posts)->toHaveCount(5);
    expect(Post::query()->count())->toBe(5);
});
