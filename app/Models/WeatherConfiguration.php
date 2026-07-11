<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\WeatherConfigurationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeatherConfiguration extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'rule_type',
        'weather',
        'recommendation',
        'status',
    ];

    /**
     * Attribute casting.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => WeatherConfigurationStatus::class,
            'deleted_at' => 'datetime',
        ];
    }
}
