<?php

namespace App\Enums;

enum VoucherStatus: string
{
    case ACTIVE = 'ACTIVE';
    case USED = 'USED';
    case EXPIRED = 'EXPIRED';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::USED => 'Used',
            self::EXPIRED => 'Expired',
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
