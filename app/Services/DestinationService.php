<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DestinationService
{
    /**
     * Get all destinations.
     *
     * @return Collection<int, Destination>
     */
    public function getAll(): Collection
    {
        return Destination::query()
            ->with('city')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get destination by ID.
     */
    public function getById(int $id): Destination
    {
        return Destination::query()
            ->with('city')
            ->findOrFail($id);
    }

    /**
     * Create destination.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): Destination
    {
        return DB::transaction(
            fn(): Destination => Destination::query()->create($data)
        );
    }

    /**
     * Update destination.
     *
     * @param array<string, mixed> $data
     */
    public function update(
        Destination $destination,
        array $data,
    ): Destination {
        return DB::transaction(function () use (
            $destination,
            $data
        ): Destination {

            $destination->update($data);

            return $destination->fresh('city');
        });
    }

    /**
     * Delete destination.
     */
    public function delete(
        Destination $destination,
    ): void {
        DB::transaction(function () use (
            $destination
        ): void {

            $destination->delete();
        });
    }
}
