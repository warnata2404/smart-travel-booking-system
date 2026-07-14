<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\WeatherConfigurationStatus;
use App\Http\Requests\StoreWeatherConfigurationRequest;
use App\Http\Requests\UpdateWeatherConfigurationRequest;
use App\Models\WeatherConfiguration;
use App\Services\WeatherConfigurationService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class WeatherConfigurationController extends Controller
{
    public function __construct(
        private readonly WeatherConfigurationService $weatherConfigurationService,
    ) {}

    /**
     * Display weather configuration list.
     */
    public function index(): Response
    {
        return Inertia::render('WeatherConfigurations/Index', [
            'weatherConfigurations' => $this->weatherConfigurationService->getAll(),
        ]);
    }

    /**
     * Display weather configuration create form.
     */
    public function create(): Response
    {
        return Inertia::render('WeatherConfigurations/Create', [
            'statuses' => WeatherConfigurationStatus::options(),
        ]);
    }

    /**
     * Store weather configuration.
     */
    public function store(
        StoreWeatherConfigurationRequest $request,
    ): RedirectResponse {

        $this->weatherConfigurationService->create(
            $request->validated(),
        );

        return redirect()
            ->route('weather-configurations.index')
            ->with(
                'success',
                'Weather configuration created successfully.',
            );
    }

    /**
     * Display weather configuration edit form.
     */
    public function edit(
        WeatherConfiguration $weatherConfiguration,
    ): Response {

        return Inertia::render('WeatherConfigurations/Edit', [

            'weatherConfiguration' => $this->weatherConfigurationService
                ->getById($weatherConfiguration->id),

            'statuses' => WeatherConfigurationStatus::options(),

        ]);
    }

    /**
     * Update weather configuration.
     */
    public function update(
        UpdateWeatherConfigurationRequest $request,
        WeatherConfiguration $weatherConfiguration,
    ): RedirectResponse {

        $this->weatherConfigurationService->update(
            $weatherConfiguration,
            $request->validated(),
        );

        return redirect()
            ->route('weather-configurations.index')
            ->with(
                'success',
                'Weather configuration updated successfully.',
            );
    }

    /**
     * Delete weather configuration.
     */
    public function destroy(
        WeatherConfiguration $weatherConfiguration,
    ): RedirectResponse {

        $this->weatherConfigurationService->delete(
            $weatherConfiguration,
        );

        return redirect()
            ->route('weather-configurations.index')
            ->with(
                'success',
                'Weather configuration deleted successfully.',
            );
    }
}
