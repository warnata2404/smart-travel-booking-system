<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\DestinationCategory;
use App\Enums\DestinationStatus;
use App\Http\Requests\StoreDestinationRequest;
use App\Http\Requests\UpdateDestinationRequest;
use App\Models\City;
use App\Models\Destination;
use App\Services\DestinationService;
use App\Support\EnumOptions;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DestinationController extends Controller
{
    public function __construct(
        private readonly DestinationService $destinationService,
    ) {}

    /**
     * Display destination list.
     */
    public function index(): Response
    {
        return Inertia::render('Destinations/Index', [
            'destinations' => $this->destinationService->getAll(),
        ]);
    }

    /**
     * Display destination create form.
     */
    public function create(): Response
    {
        return Inertia::render('Destinations/Create', [
            'cities' => City::query()
                ->orderBy('name')
                ->get(),

            'categories' => EnumOptions::from(
                DestinationCategory::class,
            ),

            'statuses' => EnumOptions::from(
                DestinationStatus::class,
            ),
        ]);
    }

    /**
     * Store destination.
     */
    public function store(
        StoreDestinationRequest $request,
    ): RedirectResponse {

        $this->destinationService->create(
            $request->validated(),
        );

        return redirect()
            ->route('destinations.index')
            ->with(
                'success',
                'Destination created successfully.',
            );
    }

    /**
     * Display destination edit form.
     */
    public function edit(
        Destination $destination,
    ): Response {

        return Inertia::render('Destinations/Edit', [
            'destination' => $this->destinationService
                ->getById($destination->id),

            'cities' => City::query()
                ->orderBy('name')
                ->get(),

            'categories' => EnumOptions::from(
                DestinationCategory::class,
            ),

            'statuses' => EnumOptions::from(
                DestinationStatus::class,
            ),
        ]);
    }

    /**
     * Update destination.
     */
    public function update(
        UpdateDestinationRequest $request,
        Destination $destination,
    ): RedirectResponse {

        $this->destinationService->update(
            $destination,
            $request->validated(),
        );

        return redirect()
            ->route('destinations.index')
            ->with(
                'success',
                'Destination updated successfully.',
            );
    }

    /**
     * Delete destination.
     */
    public function destroy(
        Destination $destination,
    ): RedirectResponse {

        $this->destinationService->delete(
            $destination,
        );

        return redirect()
            ->route('destinations.index')
            ->with(
                'success',
                'Destination deleted successfully.',
            );
    }
}
