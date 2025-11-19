<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\VideoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property-read int $id
 * @property-read string $title
 * @property-read string $embed_code
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
final class Video extends Model
{
    /** @use HasFactory<VideoFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'id' => 'integer',
            'title' => 'string',
            'embed_code' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function getStyledEmbedCodeAttribute(): string
    {
        $embedCode = $this->embed_code;

        // Add aspect-video class to iframe
        if (str_contains($embedCode, '<iframe')) {
            $embedCode = str_replace('<iframe', '<iframe class="aspect-video w-full h-full rounded-lg"', $embedCode);
        }

        // Add aspect-video class to video element
        if (str_contains($embedCode, '<video')) {
            $embedCode = str_replace('<video', '<video class="aspect-video w-full h-full rounded-lg"', $embedCode);
        }

        return $embedCode;
    }
}
