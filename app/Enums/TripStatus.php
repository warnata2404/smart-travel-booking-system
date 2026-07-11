<?php

namespace App\Enums;

enum TripStatus: string
{
    case NOT_STARTED = 'NOT_STARTED';
    case ON_GOING = 'ON_GOING';
    case COMPLETED = 'COMPLETED';

    public function label(): string
    {
        return match ($this) {
            self::NOT_STARTED => 'Not Started',
            self::ON_GOING => 'On Going',
            self::COMPLETED => 'Completed',
        };
    }

    public static function options(): array
    {
        return array_map(
            static fn(self $case) => [
                'label' => $case->label(),
                'value' => $case->value,
            ],
            self::cases()
        );
    }
}
