<?php

namespace App\Enums;

enum PaintingStatus: int
{
    case IN_STOCK = 1;
    case SENT = 2;

    /** Status titles */
    public function title(): string
    {
        return match ($this) {
            self::IN_STOCK => 'В наличии',
            self::SENT => 'Отправлено',
            default => 'unknown'
        };
    }

    /** Status colors */
    // {{ $item->status?->color() ?? 'secondary' }}
    public function color(): string
    {
        return match ($this) {
            self::IN_STOCK => 'success',
            self::SENT => 'danger',
            default => 'secondary'
        };
    }

    public static function titles_list(): array
    {
        return array_reduce(self::cases(), function ($carry, $case) {
            $carry[$case->value] = $case->title();
            return $carry;
        }, []);
    }
}
