<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

final class ImportVideosFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'videos:import {--file=public/videos.json : Path to the JSON file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import videos from JSON file into the database';

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

        $this->info("Reading videos from {$filePath}...");

        $jsonContent = File::get($fullPath);
        $videos = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Invalid JSON: '.json_last_error_msg());

            return self::FAILURE;
        }

        if (! is_array($videos)) {
            $this->error('Expected an array of videos in the JSON file');

            return self::FAILURE;
        }

        $this->info('Found '.count($videos).' videos to import');

        $progressBar = $this->output->createProgressBar(count($videos));
        $progressBar->start();

        $imported = 0;
        $updated = 0;

        foreach ($videos as $videoData) {
            if (! isset($videoData['title']) || ! isset($videoData['embed_link'])) {
                $this->newLine();
                $this->warn('Skipping video with missing title or embed_link');
                $progressBar->advance();

                continue;
            }

            $video = Video::query()->updateOrCreate(
                ['title' => $videoData['title']],
                ['embed_code' => $videoData['embed_link']]
            );

            if ($video->wasRecentlyCreated) {
                $imported++;
            } else {
                $updated++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info('Import completed successfully!');
        $this->info("Created: {$imported} videos");
        $this->info("Updated: {$updated} videos");

        return self::SUCCESS;
    }
}
