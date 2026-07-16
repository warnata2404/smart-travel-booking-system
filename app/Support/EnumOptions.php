<?php

declare(strict_types=1);

namespace App\Support;

use BackedEnum;

final class EnumOptions
{
    /**
     * Convert backed enum cases into frontend select options.
     *
     * @param class-string<BackedEnum> $enumClass
     * @return array<int, array{label:string,value:string|int}>
     */
    public static function from(string $enumClass): array
    {
        return array_map(
            static fn(BackedEnum $case): array => [
                'label' => str($case->value)
                    ->replace('_', ' ')
                    ->title()
                    ->value(),

                'value' => $case->value,
            ],
            $enumClass::cases(),
        );
    }

    private function __construct() {}
}
