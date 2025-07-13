<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\RatingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/imprint', function () {
    return view('imprint');
})->name('imprint');

Route::get('/soccerdraw', function () {
    return view('soccerdraw');
})->name('soccerdraw');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('exercises', ExerciseController::class);
    Route::resource('practices', PracticeController::class);
    Route::resource('players', PlayerController::class)->name('GET', 'players');
    Route::get('players-position-analysis', [PlayerController::class, 'positionAnalysis'])->name('players.position-analysis');

    Route::get('practices/print/{practice}', [PracticeController::class, 'print'])->name('print');
    Route::get('practices/{practice}/schedule', [PracticeController::class, 'schedule'])->name('practices.schedule');
});
