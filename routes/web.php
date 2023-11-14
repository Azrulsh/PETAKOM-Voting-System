<?php

use App\Http\Controllers\auth\UserController;
use App\Http\Controllers\ManageCandidateController;
use App\Http\Controllers\ManageCriteriaController;
use App\Http\Controllers\RateCandidateController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserType;

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
        ->group(function () {
            Route::get('/dashboard', [UserController::class, 'index']);

            // Manage Criteria
            Route::get('/viewCriteria', [ManageCriteriaController::class, 'index'],);
            Route::post('/manage-criteria', [ManageCriteriaController::class, 'store'],);
            Route::post('/manage-criteria/{id}', [ManageCriteriaController::class, 'update'],);
            Route::get('/manage-criteria/{id}/delete', [ManageCriteriaController::class, 'destroy'],);

            // Manage Candidate
            Route::get('/viewCandidate', [ManageCandidateController::class, 'index'],);
            Route::post('/manage-candidate', [ManageCandidateController::class, 'store'],);
            Route::post('/manage-candidate/{id}', [ManageCandidateController::class, 'update'],);
            Route::get('/manage-candidate/{id}/delete', [ManageCandidateController::class, 'destroy'],);

            // Report
            Route::get('/report', [ReportController::class, 'index'],);
        });

    Route::prefix('voter')
        ->as('voter.')
        ->group(function () {
            Route::get('/dashboard', [UserController::class, 'index']);
            // Rate Candidate
            Route::get('/rateCandidate', [RateCandidateController::class, 'position'],);

            // Display all Candidate on Voter Page
            Route::prefix('rateCandidate')
                ->as('rateCandidate.')
                ->group(function () {
                    // Rate Candidate (Student Warefare)
                    Route::get('/student-warefare', [RateCandidateController::class, 'display'],);
                    Route::post('/student-warefare', [RateCandidateController::class, 'store'],);

                    // Rate Candidate (Student Exco)
                    Route::get('/welfare-exco', [RateCandidateController::class, 'welfareExco'],);

                    // Rate Candidate (Sport Exco)
                    Route::get('/sports-exco', [RateCandidateController::class, 'sportsExco'],);
                });
        });
});
