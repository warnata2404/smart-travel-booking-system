<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\TravelRouteStatus;
use App\Http\Requests\StoreTravelRouteRequest;
use App\Http\Requests\UpdateTravelRouteRequest;
use App\Models\City;
use App\Models\Destination;
use App\Models\TravelRoute;
use App\Services\TravelRouteService;
use App\Support\EnumOptions;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TravelRouteController extends Controller
{
    public function __construct(
        private readonly TravelRouteService $travelRouteService,
    ) {}

    /**
     * Display travel route list.
     */
    public function index(): Response
    {
        return Inertia::render('TravelRoutes/Index', [
            'travelRoutes' => $this->travelRouteService->getAll(),
        ]);
    }

    /**
     * Display travel route create form.
     */
    public function create(): Response
    {
        return Inertia::render('TravelRoutes/Create', [

            'cities' => City::query()
                ->orderBy('name')
                ->get(),

            'destinations' => Destination::query()
                ->with('city')
                ->orderBy('name')
                ->get(),

            'statuses' => EnumOptions::from(
                TravelRouteStatus::class,
            ),

        ]);
    }

    /**
     * Store travel route.
     */
    public function store(
        StoreTravelRouteRequest $request,
    ): RedirectResponse {

        $this->travelRouteService->create(
            $request->validated(),
        );

        return redirect()
            ->route('travel-routes.index')
            ->with(
                'success',
                'Travel route created successfully.',
            );
    }

    /**
     * Display travel route edit form.
     */
    public function edit(
        TravelRoute $travelRoute,
    ): Response {

        return Inertia::render('TravelRoutes/Edit', [

            'travelRoute' => $this->travelRouteService
                ->getById($travelRoute->id),

            'cities' => City::query()
                ->orderBy('name')
                ->get(),

            'destinations' => Destination::query()
                ->with('city')
                ->orderBy('name')
                ->get(),

            'statuses' => EnumOptions::from(
                TravelRouteStatus::class,
            ),

        ]);
    }

    /**
     * Update travel route.
     */
    public function update(
        UpdateTravelRouteRequest $request,
        TravelRoute $travelRoute,
    ): RedirectResponse {

        $this->travelRouteService->update(
            $travelRoute,
            $request->validated(),
        );

        return redirect()
            ->route('travel-routes.index')
            ->with(
                'success',
                'Travel route updated successfully.',
            );
    }

    /**
     * Delete travel route.
     */
    public function destroy(
        TravelRoute $travelRoute,
    ): RedirectResponse {

        $this->travelRouteService->delete(
            $travelRoute,
        );

        return redirect()
            ->route('travel-routes.index')
            ->with(
                'success',
                'Travel route deleted successfully.',
            );
    }
}
