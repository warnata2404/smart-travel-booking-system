<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AnalyzeTravelRequest;
use App\Services\CityService;
use App\Services\TravelAnalysisService;
use App\Services\TravelRouteService;
use Inertia\Inertia;
use Inertia\Response;

class TravelAnalysisController extends Controller
{
    public function __construct(
        private readonly TravelAnalysisService $travelAnalysisService,
        private readonly CityService $cityService,
        private readonly TravelRouteService $travelRouteService,
    ) {}

    /**
     * Display the Travel Analysis page.
     */
    public function index(): Response
    {
        return Inertia::render('TravelAnalysis/Index', [

            'cities' => $this->cityService->getAll(),

            'travelRoutes' => $this->travelRouteService->getAll(),

            'analysisResult' => null,

        ]);
    }

    /**
     * Analyze a travel plan.
     */
    public function analyze(
        AnalyzeTravelRequest $request,
    ): Response {

        $analysisResult = $this->travelAnalysisService->analyze(
            $request->validated(),
        );

        return Inertia::render('TravelAnalysis/Index', [

            'cities' => $this->cityService->getAll(),

            'travelRoutes' => $this->travelRouteService->getAll(),

            'analysisResult' => $analysisResult,

        ]);
    }
}
