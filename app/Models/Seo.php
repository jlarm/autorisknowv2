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

    protected function casts(): array
    {
        return [
            'keywords' => 'array',
            'no_index' => 'boolean',
            'no_follow' => 'boolean',
        ];
    }

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
