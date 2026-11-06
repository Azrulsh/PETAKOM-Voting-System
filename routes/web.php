<?php

use App\Http\Controllers\auth\UserController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/signup', function () {
    return view('auth.register');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [UserController::class, 'index']);

    
Route::prefix('admin')
    ->as('admin.')
    ->middleware('admin')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [
            UserController::class, 'index'
        ])->name('dashboard');

        // Candidate Management
        Route::get('/candidates', [
            CandidateController::class, 'index'
        ])->name('candidates.index');

        Route::post('/candidates', [
            CandidateController::class, 'store'
        ])->name('candidates.store');

        Route::put('/candidates/{id}', [
            CandidateController::class, 'update'
        ])->name('candidates.update');

        Route::delete('/candidates/{id}', [
            CandidateController::class, 'destroy'
        ])->name('candidates.destroy');

        // Criteria Management
        Route::get('/criteria', [
            CriterionController::class, 'index'
        ])->name('criteria.index');

        Route::post('/criteria', [
            CriterionController::class, 'store'
        ])->name('criteria.store');

        Route::put('/criteria/{id}', [
            CriterionController::class, 'update'
        ])->name('criteria.update');

        Route::delete('/criteria/{id}', [
            CriterionController::class, 'destroy'
        ])->name('criteria.destroy');

        // Reports
        Route::get('/reports', [
            ReportController::class, 'index'
        ])->name('reports.index');

        Route::get('/reports/generate', [
            ReportController::class, 'display'
        ])->name('reports.generate');

        // Election Results
        Route::get('/results', [
            ResultController::class, 'index'
        ])->name('results.index');
    });


    Route::prefix('voter')
        ->as('voter.')
        ->group(function () {

            Route::get('/dashboard', [UserController::class, 'index']);

            // Rate Candidate
            Route::prefix('rateCandidate')
                ->as('rateCandidate.')
                ->group(function () {

                    // Display all positions
                    Route::get('/', [
                        RatingController::class,
                        'positions'
                    ])->name('positions');

                    // Display candidates by position
                    Route::get('/{position}', [
                        RatingController::class,
                        'index'
                    ])->name('index');

                    // Submit candidate rating
                    Route::post('/{position}', [
                        RatingController::class,
                        'store'
                    ])->name('store');
                });

            // Display election results
            Route::get('/viewResult', [
                ResultController::class,
                'index'
            ]);
        });

});
