<?php

declare(strict_types=1);

use App\Enums\Status;
use App\Enums\Visibility;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('can import posts from json file', function (): void {
    Storage::fake('public');
    Http::fake([
        'https://example.com/image1.jpg' => Http::response('fake-image-content', 200),
        'https://example.com/image2.webp' => Http::response('fake-image-content-2', 200),
    ]);

    // Create a temporary JSON file
    $jsonData = [
        [
            'ID' => 1,
            'post_title' => 'Test Post 1',
            'post_name' => 'test-post-1',
            'post_content' => 'This is test content',
            'post_date' => '2024-01-15 10:00:00',
            'post_modified' => '2024-01-15 11:00:00',
            '_links_to' => 'https://example.com/external-link',
            'featured_image_src' => 'https://example.com/image1.jpg',
        ],
        [
            'ID' => 2,
            'post_title' => 'Test Post 2',
            'post_name' => 'test-post-2',
            'post_content' => 'Another test post',
            'post_date' => '2024-01-16 10:00:00',
            'post_modified' => '2024-01-16 11:00:00',
            '_links_to' => null,
            'featured_image_src' => 'https://example.com/image2.webp',
        ],
    ];

    $tempFile = base_path('temp-posts.json');
    File::put($tempFile, json_encode($jsonData));

    $this->artisan('posts:import', ['--file' => 'temp-posts.json'])
        ->assertSuccessful();

    // Clean up
    File::delete($tempFile);

    // Assert posts were created
    expect(Post::query()->count())->toBe(2);

    $post1 = Post::query()->find(1);
    expect($post1->title)->toBe('Test Post 1');
    expect($post1->slug)->toBe('test-post-1');
    expect($post1->content)->toBe('This is test content');
    expect($post1->status)->toBe(Status::Published);
    expect($post1->visibility)->toBe(Visibility::PUBLIC);
    expect($post1->external_link)->toBe('https://example.com/external-link');
    expect($post1->featured_image)->toBe('posts/post-1.jpg');

    $post2 = Post::query()->find(2);
    expect($post2->title)->toBe('Test Post 2');
    expect($post2->external_link)->toBeNull();
    expect($post2->featured_image)->toBe('posts/post-2.webp');
});

test('handles missing required fields gracefully', function (): void {
    Storage::fake('public');

    $jsonData = [
        [
            'ID' => 1,
            'post_title' => 'Valid Post',
            'post_name' => 'valid-post',
        ],
        [
            // Missing ID
            'post_title' => 'Invalid Post',
            'post_name' => 'invalid-post',
        ],
        [
            'ID' => 3,
            // Missing title
            'post_name' => 'no-title',
        ],
    ];

    $tempFile = base_path('temp-posts-invalid.json');
    File::put($tempFile, json_encode($jsonData));

    $this->artisan('posts:import', ['--file' => 'temp-posts-invalid.json'])
        ->assertSuccessful();

    File::delete($tempFile);

    // Only the valid post should be imported
    expect(Post::query()->count())->toBe(1);
    expect(Post::query()->first()->title)->toBe('Valid Post');
});

test('updates existing posts when importing', function (): void {
    Storage::fake('public');
    Http::fake(['*' => Http::response('fake-image', 200)]);

    // Create an existing post
    Post::query()->create([
        'id' => 1,
        'title' => 'Original Title',
        'slug' => 'original-slug',
        'content' => 'Original content',
        'featured_image' => '',
        'status' => Status::Draft,
        'visibility' => Visibility::PRIVATE,
        'published_at' => now(),
    ]);

    $jsonData = [
        [
            'ID' => 1,
            'post_title' => 'Updated Title',
            'post_name' => 'updated-slug',
            'post_content' => 'Updated content',
            'post_date' => '2024-01-15 10:00:00',
            'post_modified' => '2024-01-15 11:00:00',
            'featured_image_src' => 'https://example.com/image.jpg',
        ],
    ];

    $tempFile = base_path('temp-posts-update.json');
    File::put($tempFile, json_encode($jsonData));

    $this->artisan('posts:import', ['--file' => 'temp-posts-update.json'])
        ->assertSuccessful();

    File::delete($tempFile);

    expect(Post::query()->count())->toBe(1);

    $post = Post::query()->find(1);
    expect($post->title)->toBe('Updated Title');
    expect($post->slug)->toBe('updated-slug');
    expect($post->content)->toBe('Updated content');
    expect($post->status)->toBe(Status::Published);
    expect($post->visibility)->toBe(Visibility::PUBLIC);
});

test('handles failed image downloads gracefully', function (): void {
    Storage::fake('public');
    Http::fake([
        'https://example.com/bad-image.jpg' => Http::response('', 404),
    ]);

    $jsonData = [
        [
            'ID' => 1,
            'post_title' => 'Post with Failed Image',
            'post_name' => 'post-with-failed-image',
            'post_content' => 'Content',
            'post_date' => '2024-01-15 10:00:00',
            'post_modified' => '2024-01-15 11:00:00',
            'featured_image_src' => 'https://example.com/bad-image.jpg',
        ],
    ];

    $tempFile = base_path('temp-posts-bad-image.json');
    File::put($tempFile, json_encode($jsonData));

    $this->artisan('posts:import', ['--file' => 'temp-posts-bad-image.json'])
        ->assertSuccessful();

    File::delete($tempFile);

    $post = Post::query()->find(1);
    expect($post)->not->toBeNull();
    expect($post->featured_image)->toBe('');
});

test('fails when json file does not exist', function (): void {
    $this->artisan('posts:import', ['--file' => 'nonexistent.json'])
        ->assertFailed();
});

test('fails with invalid json', function (): void {
    $tempFile = base_path('temp-invalid.json');
    File::put($tempFile, 'not valid json{');

    $this->artisan('posts:import', ['--file' => 'temp-invalid.json'])
        ->assertFailed();

    File::delete($tempFile);
});
