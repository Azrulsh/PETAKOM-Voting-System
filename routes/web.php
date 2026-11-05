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
            Route::get('/dashboard', [UserController::class, 'index']);

            // Manage Criteria
            Route::get('/viewCriteria', [CriterionController::class, 'index'],);
            Route::post('/manage-criteria', [CriterionController::class, 'store'],);
            Route::post('/manage-criteria/{id}', [CriterionController::class, 'update'],);
            Route::get('/manage-criteria/{id}/delete', [CriterionController::class, 'destroy'],);

            // Manage Candidate
            Route::get('/viewCandidate', [CandidateController::class, 'index'],);
            Route::post('/manage-candidate', [CandidateController::class, 'store'],);
            Route::post('/manage-candidate/{id}', [CandidateController::class, 'update'],);
            Route::get('/manage-candidate/{id}/delete', [CandidateController::class, 'destroy'],);

            // Report

            Route::get('/report', [ReportController::class, 'index'],);
            Route::prefix('report')
                ->as('report.')
                ->group(function () {
                    Route::get('/generate', [ReportController::class, 'display'],);

                    // Generate Result
                    Route::prefix('generate')
                        ->as('generate.')
                        ->group(function () {
                            Route::get('/result', [ResultController::class, 'index'],);
                        });
                });
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
