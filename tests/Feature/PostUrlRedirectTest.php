<?php

declare(strict_types=1);

test('old date-based post URLs redirect to new news URLs with 301 status', function (): void {
    $response = $this->get('/2025/03/18/defensive-and-offensive-strategies-for-thwarting-cyberattacks-at-ais-nrc-summit');

    $response->assertStatus(301);
    $response->assertRedirect('/news/defensive-and-offensive-strategies-for-thwarting-cyberattacks-at-ais-nrc-summit');
});

test('redirect preserves the post slug correctly', function (): void {
    $response = $this->get('/2024/12/01/sample-post-title');

    $response->assertStatus(301);
    $response->assertRedirect('/news/sample-post-title');
});

test('redirect only matches valid date patterns', function (): void {
    // This should not match the redirect route (invalid year format)
    $response = $this->get('/25/03/18/some-slug');

    $response->assertNotFound();
});
