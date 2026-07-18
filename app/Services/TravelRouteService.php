<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\TravelRouteStatus;
use App\Models\TravelRoute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TravelRouteService
{
    /**
     * Get all active travel routes.
     *
     * @return Collection<int, TravelRoute>
     */
    public function getAll(): Collection
    {
        return TravelRoute::query()
            ->with([
                'originCity',
                'destination',
                'destination.city',
            ])
            ->where(
                'status',
                TravelRouteStatus::ACTIVE,
            )
            ->orderBy('origin_city_id')
            ->orderBy('destination_id')
            ->get();
    }

    /**
     * Get travel route by ID.
     */
    public function getById(
        int $id,
    ): TravelRoute {
        return TravelRoute::query()
            ->with([
                'originCity',
                'destination',
                'destination.city',
            ])
            ->findOrFail($id);
    }

    /**
     * Create travel route.
     *
     * @param array<string, mixed> $data
     */
    public function create(
        array $data,
    ): TravelRoute {
        return DB::transaction(
            fn(): TravelRoute => TravelRoute::query()->create($data)
        );
    }

    /**
     * Update travel route.
     *
     * @param array<string, mixed> $data
     */
    public function update(
        TravelRoute $travelRoute,
        array $data,
    ): TravelRoute {
        return DB::transaction(function () use (
            $travelRoute,
            $data,
        ): TravelRoute {

            $travelRoute->update($data);

            return $travelRoute->fresh([
                'originCity',
                'destination',
                'destination.city',
            ]);
        });
    }

    /**
     * Delete travel route.
     */
    public function delete(
        TravelRoute $travelRoute,
    ): void {
        DB::transaction(function () use (
            $travelRoute,
        ): void {

            $travelRoute->delete();
        });
    }
}
