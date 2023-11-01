<?php

use App\Http\Controllers\auth\UserController;
use App\Http\Controllers\ManageCandidateController;
use App\Http\Controllers\ManageCriteriaController;
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
    Route::get('/dashboard', [UserController::class, 'index']);
    Route::get('/', [UserController::class, 'index']);
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Manage Criteria
    Route::get('/', [ManageCriteriaController::class, 'index'],);
    Route::post('/manage-criteria', [ManageCriteriaController::class, 'store'],);
    Route::post('/manage-criteria/{id}', [ManageCriteriaController::class, 'update'],);
    Route::get('/manage-criteria/{id}/delete', [ManageCriteriaController::class, 'destroy'],);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Manage Candidate
    Route::get('/', [ManageCandidateController::class, 'index'],);
    Route::post('/manage-candidate', [ManageCandidateController::class, 'store'],);
    Route::post('/manage-candidate/{id}', [ManageCandidateController::class, 'update'],);
    Route::get('/manage-candidate/{id}/delete', [ManageCandidateController::class, 'destroy'],);
});
