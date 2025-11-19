<?php

declare(strict_types=1);

use App\Services\SeoService;

beforeEach(function (): void {
    if (! config('services.anthropic.api_key')) {
        $this->markTestSkipped('Anthropic API key not configured');
    }
});

test('generates twitter card metadata', function (): void {
    $service = new SeoService();

    $result = $service->generateTwitterCard([
        'title' => 'Understanding Laravel SEO Best Practices',
        'content' => 'Learn how to optimize your Laravel application for search engines with proper meta tags, structured data, and content optimization techniques.',
    ]);

    expect($result)
        ->toHaveKey('card')
        ->toHaveKey('title')
        ->toHaveKey('description')
        ->toHaveKey('titleAlternatives')
        ->toHaveKey('descriptionAlternatives');

    expect($result['card'])->toBeIn(['summary', 'summary_large_image', 'app', 'player']);
    expect($result['title'])->toBeString()->not->toBeEmpty();
    expect($result['description'])->toBeString()->not->toBeEmpty();
    expect($result['titleAlternatives'])->toBeArray();
    expect($result['descriptionAlternatives'])->toBeArray();

    expect(mb_strlen($result['title']))->toBeLessThanOrEqual(70);
    expect(mb_strlen($result['description']))->toBeLessThanOrEqual(200);
});

test('generates meta description', function (): void {
    $service = new SeoService();

    $result = $service->generateMetaDescription([
        'title' => 'Laravel SEO Guide',
        'content' => 'Complete guide to optimizing Laravel applications for search engines.',
    ]);

    expect($result)
        ->toHaveKey('description')
        ->toHaveKey('alternatives');

    expect($result['description'])->toBeString()->not->toBeEmpty();
    expect($result['alternatives'])->toBeArray();
    expect(mb_strlen($result['description']))->toBeLessThanOrEqual(180);
});

test('generates seo title', function (): void {
    $service = new SeoService();

    $result = $service->generateSeoTitle([
        'title' => 'Laravel SEO Best Practices',
        'content' => 'Learn how to optimize your Laravel application for search engines.',
    ]);

    expect($result)
        ->toHaveKey('title')
        ->toHaveKey('alternatives');

    expect($result['title'])->toBeString()->not->toBeEmpty();
    expect($result['alternatives'])->toBeArray();
    expect(mb_strlen($result['title']))->toBeLessThanOrEqual(60);
});

test('analyzes content for seo', function (): void {
    $service = new SeoService();

    $result = $service->analyzeContent([
        'title' => 'Laravel SEO Guide',
        'content' => 'Complete guide to optimizing Laravel applications for search engines with proper implementation.',
        'metaTitle' => 'Laravel SEO Guide - Best Practices',
        'metaDescription' => 'Learn how to optimize your Laravel application for search engines.',
    ]);

    expect($result)
        ->toHaveKey('score')
        ->toHaveKey('issues')
        ->toHaveKey('recommendations')
        ->toHaveKey('keywords');

    expect($result['score'])->toBeInt()->toBeGreaterThanOrEqual(0)->toBeLessThanOrEqual(100);
    expect($result['issues'])->toBeArray();
    expect($result['recommendations'])->toBeArray();
    expect($result['keywords'])->toBeArray();
});
