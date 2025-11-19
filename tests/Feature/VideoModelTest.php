<?php

declare(strict_types=1);

use App\Models\Seo;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create a video with factory', function (): void {
    $video = Video::factory()->create();

    expect($video)->toBeInstanceOf(Video::class);
    expect($video->id)->toBeInt();
    expect($video->title)->toBeString()->not->toBeEmpty();
    expect($video->embed_code)->toBeString()->not->toBeEmpty();
});

test('video has correct casts', function (): void {
    $video = Video::factory()->create();

    expect($video->id)->toBeInt();
    expect($video->title)->toBeString();
    expect($video->embed_code)->toBeString();
    expect($video->created_at)->toBeInstanceOf(Carbon::class);
    expect($video->updated_at)->toBeInstanceOf(Carbon::class);
});

test('video factory generates youtube embed code', function (): void {
    $video = Video::factory()->create();

    $isYouTube = str_contains($video->embed_code, 'youtube.com');
    $isVimeo = str_contains($video->embed_code, 'vimeo.com');

    expect($isYouTube || $isVimeo)->toBeTrue();
    expect($video->embed_code)->toContain('<iframe');
    expect($video->embed_code)->toContain('</iframe>');
});

test('video has seo relationship', function (): void {
    $video = Video::factory()->create();
    $seo = Seo::factory()->create([
        'seoable_type' => Video::class,
        'seoable_id' => $video->id,
    ]);

    expect($video->seo)->toBeInstanceOf(Seo::class);
    expect($video->seo->id)->toBe($seo->id);
});

test('video seo relationship returns null when no seo exists', function (): void {
    $video = Video::factory()->create();

    expect($video->seo)->toBeNull();
});

test('video can be updated', function (): void {
    $video = Video::factory()->create(['title' => 'Original Title']);

    $video->update(['title' => 'Updated Title']);

    expect($video->fresh()->title)->toBe('Updated Title');
});

test('video embed code can be updated', function (): void {
    $video = Video::factory()->create();
    $newEmbedCode = '<iframe src="https://www.youtube.com/embed/newtestid" width="560" height="315"></iframe>';

    $video->update(['embed_code' => $newEmbedCode]);

    expect($video->fresh()->embed_code)->toBe($newEmbedCode);
});

test('video can be deleted', function (): void {
    $video = Video::factory()->create();
    $videoId = $video->id;

    $video->delete();

    expect(Video::query()->find($videoId))->toBeNull();
});

test('multiple videos can be created', function (): void {
    $videos = Video::factory()->count(5)->create();

    expect($videos)->toHaveCount(5);
    expect(Video::query()->count())->toBe(5);
});

test('video factory generates valid youtube embed structure', function (): void {
    $video = Video::factory()->create();

    if (str_contains($video->embed_code, 'youtube.com')) {
        expect($video->embed_code)->toContain('youtube.com/embed/');
        expect($video->embed_code)->toContain('width="560"');
        expect($video->embed_code)->toContain('height="315"');
        expect($video->embed_code)->toContain('allowfullscreen');
    }
});

test('video factory generates valid vimeo embed structure', function (): void {
    $video = Video::factory()->create();

    if (str_contains($video->embed_code, 'vimeo.com')) {
        expect($video->embed_code)->toContain('player.vimeo.com/video/');
        expect($video->embed_code)->toContain('width="640"');
        expect($video->embed_code)->toContain('height="360"');
        expect($video->embed_code)->toContain('allowfullscreen');
    }
});

test('can create video with custom title', function (): void {
    $customTitle = 'My Custom Video Title';
    $video = Video::factory()->create(['title' => $customTitle]);

    expect($video->title)->toBe($customTitle);
});
