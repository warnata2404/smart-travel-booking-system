<?php

declare(strict_types=1);

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RewardConfigurationController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\TravelAnalysisController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\WeatherConfigurationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/dashboard');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [
    DashboardController::class,
    'index',
])
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'verified',
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'edit',
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update',
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy',
    ])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Administrator
    |--------------------------------------------------------------------------
    */

    Route::middleware([
        'admin',
    ])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | City
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'cities',
            CityController::class,
        )->except([
            'show',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Destination
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'destinations',
            DestinationController::class,
        )->except([
            'show',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Reward Configuration
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'reward-configurations',
            RewardConfigurationController::class,
        )->except([
            'show',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Weather Configuration
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'weather-configurations',
            WeatherConfigurationController::class,
        )->except([
            'show',
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Travel Analysis
    |--------------------------------------------------------------------------
    */

    Route::prefix('travel-analysis')
        ->name('travel-analysis.')
        ->group(function () {

            Route::get('/', [
                TravelAnalysisController::class,
                'index',
            ])->name('index');

            Route::post('/analyze', [
                TravelAnalysisController::class,
                'analyze',
            ])->name('analyze');
        });

    /*
    |--------------------------------------------------------------------------
    | Booking
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'bookings',
        BookingController::class,
    )->only([
        'index',
        'create',
        'store',
        'show',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'payments',
        PaymentController::class,
    )->only([
        'index',
        'create',
        'store',
        'show',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Trip
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'trips',
        TripController::class,
    )->only([
        'index',
        'show',
    ]);

    Route::post('/trips/{trip}/start', [
        TripController::class,
        'start',
    ])->name('trips.start');

    Route::post('/trips/{trip}/complete', [
        TripController::class,
        'complete',
    ])->name('trips.complete');

    /*
    |--------------------------------------------------------------------------
    | Reward
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'rewards',
        RewardController::class,
    )->only([
        'index',
        'show',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Voucher
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'vouchers',
        VoucherController::class,
    )->only([
        'index',
        'show',
    ]);
});

require __DIR__ . '/auth.php';
