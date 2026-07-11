<?php

namespace App\Enums;

enum DestinationCategory: string
{
    case INDOOR = 'INDOOR';
    case OUTDOOR = 'OUTDOOR';

    public function label(): string
    {
        return match ($this) {
            self::INDOOR => 'Indoor',
            self::OUTDOOR => 'Outdoor',
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
