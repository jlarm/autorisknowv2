<?php

declare(strict_types=1);

namespace App\Enums;

enum Visibility: string
{
    case PUBLIC = 'public';
    case PRIVATE = 'private';

    public function label(): string
    {
        return match ($this) {
            self::PUBLIC => 'Public',
            self::PRIVATE => 'Private',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PUBLIC => 'green',
            self::PRIVATE => 'red',
        };
    }
}
