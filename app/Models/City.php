<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CityStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
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
            'status' => CityStatus::class,
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Destinations that belong to this city.
     */
    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }

    /**
     * Travel routes that originate from this city.
     */
    public function travelRoutes(): HasMany
    {
        return $this->hasMany(
            TravelRoute::class,
            'origin_city_id',
        );
    }
}
