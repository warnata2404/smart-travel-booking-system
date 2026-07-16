<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\CityStatus;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use App\Services\CityService;
use App\Support\EnumOptions;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CityController extends Controller
{
    public function __construct(
        private readonly CityService $cityService,
    ) {}

    /**
     * Display city list.
     */
    public function index(): Response
    {
        return Inertia::render('Cities/Index', [
            'cities' => $this->cityService->getAll(),
        ]);
    }

    /**
     * Display create form.
     */
    public function create(): Response
    {
        return Inertia::render('Cities/Create', [
            'statuses' => EnumOptions::from(CityStatus::class),
        ]);
    }

    /**
     * Store city.
     */
    public function store(
        StoreCityRequest $request,
    ): RedirectResponse {

        $this->cityService->create(
            $request->validated(),
        );

        return redirect()
            ->route('cities.index')
            ->with(
                'success',
                'City created successfully.',
            );
    }

    /**
     * Display edit form.
     */
    public function edit(
        City $city,
    ): Response {

        return Inertia::render('Cities/Edit', [
            'city' => $this->cityService->getById($city->id),

            'statuses' => EnumOptions::from(
                CityStatus::class,
            ),
        ]);
    }

    /**
     * Update city.
     */
    public function update(
        UpdateCityRequest $request,
        City $city,
    ): RedirectResponse {

        $this->cityService->update(
            $city,
            $request->validated(),
        );

        return redirect()
            ->route('cities.index')
            ->with(
                'success',
                'City updated successfully.',
            );
    }

    /**
     * Delete city.
     */
    public function destroy(
        City $city,
    ): RedirectResponse {

        $this->cityService->delete($city);

        return redirect()
            ->route('cities.index')
            ->with(
                'success',
                'City deleted successfully.',
            );
    }
}
