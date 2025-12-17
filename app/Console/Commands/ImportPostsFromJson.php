<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Status;
use App\Enums\Visibility;
use App\Models\Post;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

final class ImportPostsFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:import {--file=public/posts.json : Path to the JSON file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import posts from JSON file into the database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $filePath = $this->option('file');
        $fullPath = base_path($filePath);

        if (! File::exists($fullPath)) {
            $this->error("File not found: {$filePath}");

            return self::FAILURE;
        }

        $this->info("Reading posts from {$filePath}...");

        $jsonContent = File::get($fullPath);
        $posts = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Invalid JSON: '.json_last_error_msg());

            return self::FAILURE;
        }

        if (! is_array($posts)) {
            $this->error('Expected an array of posts in the JSON file');

            return self::FAILURE;
        }

        $this->info('Found '.count($posts).' posts to import');

        // Ensure the storage directory exists
        Storage::disk('public')->makeDirectory('posts');

        $progressBar = $this->output->createProgressBar(count($posts));
        $progressBar->start();

        $imported = 0;
        $updated = 0;
        $errors = 0;

        foreach ($posts as $postData) {
            try {
                if (! isset($postData['ID']) || ! isset($postData['post_title'])) {
                    $this->newLine();
                    $this->warn('Skipping post with missing ID or title');
                    $progressBar->advance();
                    $errors++;

                    continue;
                }

                // Download and save the featured image
                $featuredImagePath = null;
                if (! empty($postData['featured_image_src'])) {
                    $featuredImagePath = $this->downloadImage($postData['featured_image_src'], $postData['ID']);
                }

                // Prepare post data
                $data = [
                    'title' => $postData['post_title'],
                    'slug' => $postData['post_name'],
                    'content' => $postData['post_content'] ?? '',
                    'featured_image' => $featuredImagePath ?? '',
                    'status' => Status::Published,
                    'visibility' => Visibility::PUBLIC,
                    'published_at' => $postData['post_date'] ?? now(),
                    'external_link' => $postData['_links_to'] ?? null,
                    'created_at' => $postData['post_date'] ?? now(),
                    'updated_at' => $postData['post_modified'] ?? now(),
                ];

                $post = Post::query()->updateOrCreate(
                    ['id' => $postData['ID']],
                    $data
                );

                if ($post->wasRecentlyCreated) {
                    $imported++;
                } else {
                    $updated++;
                }
            } catch (Exception $e) {
                $this->newLine();
                $this->error("Error importing post ID {$postData['ID']}: {$e->getMessage()}");
                $errors++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info('Import completed!');
        $this->info("Created: {$imported} posts");
        $this->info("Updated: {$updated} posts");

        if ($errors > 0) {
            $this->warn("Errors: {$errors} posts");
        }

        return self::SUCCESS;
    }

    /**
     * Download an image from a URL and save it to storage
     */
    private function downloadImage(string $url, int $postId): ?string
    {
        try {
            $response = Http::timeout(30)->get($url);

            if (! $response->successful()) {
                $this->newLine();
                $this->warn("Failed to download image for post {$postId}: HTTP {$response->status()}");

                return null;
            }

            // Get the file extension from the URL
            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (empty($extension)) {
                $extension = 'jpg'; // Default to jpg if no extension found
            }

            // Generate a filename
            $filename = "post-{$postId}.{$extension}";
            $path = "posts/{$filename}";

            // Save the image
            Storage::disk('public')->put($path, $response->body());

            return $path;
        } catch (Exception $e) {
            $this->newLine();
            $this->warn("Failed to download image for post {$postId}: {$e->getMessage()}");

            return null;
        }
    }
}
