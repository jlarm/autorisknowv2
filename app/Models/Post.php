<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use App\Enums\Visibility;
use Carbon\CarbonImmutable;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read string $title
 * @property-read string $slug
 * @property-read string $content
 * @property-read string $featured_image
 * @property-read Status $status
 * @property-read Visibility $visibility
 * @property-read CarbonImmutable $published_at
 * @property-read string|null $external_link
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
final class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'id' => 'integer',
            'title' => 'string',
            'slug' => 'string',
            'content' => 'string',
            'featured_image' => 'string',
            'status' => Status::class,
            'visibility' => Visibility::class,
            'published_at' => 'date',
            'external_link' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
