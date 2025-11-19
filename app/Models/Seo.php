<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SeoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Seo extends Model
{
    /** @use HasFactory<SeoFactory> */
    use HasFactory;

    /**
     * Get the Twitter Card type with a sensible default
     */
    public function getTwitterCardTypeAttribute(): string
    {
        return $this->twitter_card ?? 'summary_large_image';
    }

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'keywords' => 'array',
            'no_index' => 'boolean',
            'no_follow' => 'boolean',
        ];
    }
}
