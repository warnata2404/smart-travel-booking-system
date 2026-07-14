<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\RewardService;
use Inertia\Inertia;
use Inertia\Response;

class RewardController extends Controller
{
    public function __construct(
        private readonly RewardService $rewardService,
    ) {}

    /**
     * Display reward list.
     */
    public function index(): Response
    {
        return Inertia::render('Rewards/Index', [
            'rewards' => $this->rewardService->getAll(),
        ]);
    }

    /**
     * Display reward detail.
     */
    public function show(int $reward): Response
    {
        return Inertia::render('Rewards/Show', [
            'reward' => $this->rewardService->getById($reward),
        ]);
    }
}
