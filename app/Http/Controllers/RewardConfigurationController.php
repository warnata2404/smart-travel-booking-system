<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\RewardConfigurationStatus;
use App\Http\Requests\StoreRewardConfigurationRequest;
use App\Http\Requests\UpdateRewardConfigurationRequest;
use App\Models\RewardConfiguration;
use App\Services\RewardConfigurationService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RewardConfigurationController extends Controller
{
    public function __construct(
        private readonly RewardConfigurationService $rewardConfigurationService,
    ) {}

    /**
     * Display reward configuration list.
     */
    public function index(): Response
    {
        return Inertia::render('RewardConfigurations/Index', [
            'rewardConfigurations' => $this->rewardConfigurationService->getAll(),
        ]);
    }

    /**
     * Display reward configuration create form.
     */
    public function create(): Response
    {
        return Inertia::render('RewardConfigurations/Create', [
            'statuses' => RewardConfigurationStatus::options(),
        ]);
    }

    /**
     * Store reward configuration.
     */
    public function store(
        StoreRewardConfigurationRequest $request,
    ): RedirectResponse {

        $this->rewardConfigurationService->create(
            $request->validated(),
        );

        return redirect()
            ->route('reward-configurations.index')
            ->with(
                'success',
                'Reward configuration created successfully.',
            );
    }

    /**
     * Display reward configuration edit form.
     */
    public function edit(
        RewardConfiguration $rewardConfiguration,
    ): Response {

        return Inertia::render('RewardConfigurations/Edit', [

            'rewardConfiguration' => $this->rewardConfigurationService
                ->getById($rewardConfiguration->id),

            'statuses' => RewardConfigurationStatus::options(),

        ]);
    }

    /**
     * Update reward configuration.
     */
    public function update(
        UpdateRewardConfigurationRequest $request,
        RewardConfiguration $rewardConfiguration,
    ): RedirectResponse {

        $this->rewardConfigurationService->update(
            $rewardConfiguration,
            $request->validated(),
        );

        return redirect()
            ->route('reward-configurations.index')
            ->with(
                'success',
                'Reward configuration updated successfully.',
            );
    }

    /**
     * Delete reward configuration.
     */
    public function destroy(
        RewardConfiguration $rewardConfiguration,
    ): RedirectResponse {

        $this->rewardConfigurationService->delete(
            $rewardConfiguration,
        );

        return redirect()
            ->route('reward-configurations.index')
            ->with(
                'success',
                'Reward configuration deleted successfully.',
            );
    }
}
