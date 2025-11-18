<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use App\Enums\Visibility;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            'published_at' => 'datetime',
            'external_link' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
