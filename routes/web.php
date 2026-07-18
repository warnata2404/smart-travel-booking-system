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
use App\Http\Controllers\TravelRouteController;
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

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Administrator
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin')->group(function () {

        Route::resource('cities', CityController::class)
            ->except(['show']);

        Route::resource('destinations', DestinationController::class)
            ->except(['show']);

        Route::resource('travel-routes', TravelRouteController::class)
            ->except(['show']);

        Route::resource('reward-configurations', RewardConfigurationController::class)
            ->except(['show']);

        Route::resource('weather-configurations', WeatherConfigurationController::class)
            ->except(['show']);
    });

    /*
    |--------------------------------------------------------------------------
    | Bookings
    |--------------------------------------------------------------------------
    */

    Route::prefix('bookings')
        ->name('bookings.')
        ->group(function () {

            Route::get('/', [BookingController::class, 'index'])
                ->name('index');

            Route::get('/create', [BookingController::class, 'create'])
                ->name('create');

            Route::post('/review', [BookingController::class, 'review'])
                ->name('review');

            Route::post('/', [BookingController::class, 'store'])
                ->name('store');

            Route::get('/{booking}', [BookingController::class, 'show'])
                ->name('show');
        });

    /*
    |--------------------------------------------------------------------------
    | Payments
    |--------------------------------------------------------------------------
    */

    Route::resource('payments', PaymentController::class)
        ->only([
            'index',
            'create',
            'store',
            'show',
        ]);

    /*
    |--------------------------------------------------------------------------
    | Trips
    |--------------------------------------------------------------------------
    */

    Route::resource('trips', TripController::class)
        ->only([
            'index',
            'show',
        ]);

    Route::post('/trips/{trip}/start', [TripController::class, 'start'])
        ->name('trips.start');

    Route::post('/trips/{trip}/complete', [TripController::class, 'complete'])
        ->name('trips.complete');

    /*
    |--------------------------------------------------------------------------
    | Rewards
    |--------------------------------------------------------------------------
    */

    Route::resource('rewards', RewardController::class)
        ->only([
            'index',
            'show',
        ]);

    /*
    |--------------------------------------------------------------------------
    | Vouchers
    |--------------------------------------------------------------------------
    */

    Route::resource('vouchers', VoucherController::class)
        ->only([
            'index',
            'show',
        ]);
});

require __DIR__ . '/auth.php';
