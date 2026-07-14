<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CityService
{
    /**
     * Get all cities.
     *
     * @return Collection<int, City>
     */
    public function getAll(): Collection
    {
        return City::query()
            ->orderBy('name')
            ->get();
    }

    /**
     * Get city by ID.
     */
    public function getById(int $id): City
    {
        return City::query()
            ->findOrFail($id);
    }

    /**
     * Create city.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): City
    {
        return DB::transaction(function () use ($data): City {

            return City::query()->create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'status' => $data['status'],
            ]);
        });
    }

    /**
     * Update city.
     *
     * @param array<string, mixed> $data
     */
    public function update(
        City $city,
        array $data,
    ): City {
        return DB::transaction(function () use (
            $city,
            $data
        ): City {

            $city->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'status' => $data['status'],
            ]);

            return $city->fresh();
        });
    }

    /**
     * Delete city.
     */
    public function delete(City $city): void
    {
        DB::transaction(function () use ($city): void {

            $city->delete();
        });
    }
}
