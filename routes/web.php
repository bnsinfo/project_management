<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

// Redirect home → dashboard
Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | SINGLE DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



    /*
    |--------------------------------------------------------------------------
    | USER PROFILE ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile')->name('profile.')->group(function () {

        Route::get('/', [ProfileController::class, 'edit'])
            ->name('edit');

        Route::patch('/', [ProfileController::class, 'update'])
            ->name('update');

        Route::delete('/', [ProfileController::class, 'destroy'])
            ->name('destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | PROJECT ROUTES
    |--------------------------------------------------------------------------
    | Using route prefix + name prefix + permission middleware.
    |--------------------------------------------------------------------------
    */

    Route::prefix('projects')->name('projects.')->group(function () {

        // LIST
        Route::get('/', [ProjectController::class, 'index'])
            ->middleware(['permission:project.view'])
            ->name('index');

        // CREATE (must come BEFORE {project})
        Route::get('/create', [ProjectController::class, 'create'])
            ->middleware(['permission:project.create'])
            ->name('create');

        Route::post('/', [ProjectController::class, 'store'])
            ->middleware(['permission:project.create'])
            ->name('store');

        // EDIT (must come BEFORE {project})
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])
            ->middleware(['permission:project.update'])
            ->name('edit');

        // SHOW
        Route::get('/{project}', [ProjectController::class, 'show'])
            ->middleware(['permission:project.view'])
            ->name('show');

        // UPDATE
        Route::put('/{project}', [ProjectController::class, 'update'])
            ->middleware(['permission:project.update'])
            ->name('update');

        // DELETE
        Route::delete('/{project}', [ProjectController::class, 'destroy'])
            ->middleware(['permission:project.delete'])
            ->name('destroy');

        Route::post('{project}/status', [ProjectController::class, 'updateStatus'])
            ->name('updateStatus');

        // FOLLOW UP ROUTES
        Route::prefix('followup')->name('followup.')->group(function () {

            Route::get('/{id}/add', [FollowUpController::class, 'add'])
                ->middleware(['permission:project.view'])
                ->name('add');

            Route::post('/{id}/store', [FollowUpController::class, 'store'])
                ->middleware(['permission:project.view'])
                ->name('store');
        });
    });


    Route::resource('payments', PaymentController::class);
    Route::resource('clients', ClientController::class);


});

// Breeze Auth Routes
require __DIR__ . '/auth.php';
