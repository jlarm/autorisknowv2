<?php

declare(strict_types=1);

namespace App\Services;

use Anthropic\Client;
use Anthropic\Messages\MessageParam;
use RuntimeException;

final class SeoService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(
            apiKey: config('services.anthropic.api_key')
        );
    }

    /**
     * Generate meta description based on content
     *
     * @param  array{title: string, content: string}  $data
     * @return array{description: string, alternatives: array<int, string>}
     */
    public function generateMetaDescription(array $data): array
    {
        $prompt = <<<PROMPT
You are an SEO expert. Generate a compelling meta description for a blog post.

Title: {$data['title']}
Content: {$data['content']}

Requirements:
- 150-160 characters maximum
- Include relevant keywords naturally
- Make it compelling and click-worthy
- Accurately summarize the content
- No quotation marks around the description

Respond with JSON in this exact format:
{
  "description": "The main meta description",
  "alternatives": ["Alternative 1", "Alternative 2", "Alternative 3"]
}
PROMPT;

        $response = $this->client->messages->create(
            model: 'claude-sonnet-4-20250514',
            maxTokens: 1024,
            messages: [
                MessageParam::with(role: 'user', content: $prompt),
            ]
        );

        $content = $response->content[0]->text;

        return $this->parseJsonResponse($content);
    }

    /**
     * Generate SEO-optimized title suggestions
     *
     * @param  array{title: string, content: string}  $data
     * @return array{title: string, alternatives: array<int, string>}
     */
    public function generateSeoTitle(array $data): array
    {
        $prompt = <<<PROMPT
You are an SEO expert. Generate an optimized SEO title (meta title) for a blog post.

Current Title: {$data['title']}
Content: {$data['content']}

Requirements:
- 50-60 characters maximum (critical for Google display)
- Include primary keywords early in the title
- Make it compelling and click-worthy
- Front-load important words
- No quotation marks around the title

Respond with JSON in this exact format:
{
  "title": "The main SEO title",
  "alternatives": ["Alternative 1", "Alternative 2", "Alternative 3"]
}
PROMPT;

        $response = $this->client->messages->create(
            model: 'claude-sonnet-4-20250514',
            maxTokens: 1024,
            messages: [
                MessageParam::with(role: 'user', content: $prompt),
            ]
        );

        $content = $response->content[0]->text;

        return $this->parseJsonResponse($content);
    }

    /**
     * Analyze content for SEO best practices
     *
     * @param  array{title: string, content: string, metaTitle?: string, metaDescription?: string}  $data
     * @return array{score: int, issues: array<int, string>, recommendations: array<int, string>, keywords: array<int, string>}
     */
    public function analyzeContent(array $data): array
    {
        $metaTitle = $data['metaTitle'] ?? '';
        $metaDescription = $data['metaDescription'] ?? '';

        $prompt = <<<PROMPT
You are an SEO expert. Analyze this blog post content for SEO best practices.

Title: {$data['title']}
Content: {$data['content']}
Meta Title: {$metaTitle}
Meta Description: {$metaDescription}

Analyze the following:
1. Content quality and readability
2. Keyword usage and density
3. Heading structure (if HTML provided)
4. Meta title optimization (character count, keyword placement)
5. Meta description optimization (character count, compelling nature)
6. Content length
7. Overall SEO health

Respond with JSON in this exact format:
{
  "score": 85,
  "issues": ["Issue 1", "Issue 2"],
  "recommendations": ["Recommendation 1", "Recommendation 2"],
  "keywords": ["keyword1", "keyword2", "keyword3"]
}

The score should be 0-100 where 100 is perfect SEO.
PROMPT;

        $response = $this->client->messages->create(
            model: 'claude-sonnet-4-20250514',
            maxTokens: 2048,
            messages: [
                MessageParam::with(role: 'user', content: $prompt),
            ]
        );

        $content = $response->content[0]->text;

        return $this->parseJsonResponse($content);
    }

    /**
     * Parse JSON response from Claude, handling markdown code blocks
     *
     * @return array<string, mixed>
     */
    private function parseJsonResponse(string $content): array
    {
        $content = mb_trim($content);

        if (str_starts_with($content, '```json')) {
            $content = preg_replace('/^```json\s*/', '', $content);
            $content = preg_replace('/\s*```$/', '', $content);
        } elseif (str_starts_with($content, '```')) {
            $content = preg_replace('/^```\s*/', '', $content);
            $content = preg_replace('/\s*```$/', '', $content);
        }

        $decoded = json_decode(mb_trim($content), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Failed to parse JSON response: '.json_last_error_msg());
        }

        return $decoded;
    }
}
