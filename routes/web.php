<?php

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
});

Route::get('/phpinfo1', function () {
    return view('phpinfo');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->resource('exercises', ExerciseController::class)->name('get', 'exercises');

Route::middleware(['auth:sanctum', 'verified'])->resource('practices', PracticeController::class)->name('get', 'practices');

Route::middleware(['auth:sanctum', 'verified'])->resource('players', PlayerController::class)->name('get', 'players');

Route::middleware(['auth:sanctum', 'verified'])->resource('ratings', RatingController::class)->name('get', 'ratings');

Route::get('practices/api/exercises', [ExerciseController::class, 'getExerciseAutocomplete']);

