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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('exercises', ExerciseController::class);
    Route::resource('practices', PracticeController::class);
    Route::resource('players', PlayerController::class)->name('GET', 'players');
    Route::resource('ratings', RatingController::class);

    Route::get('practices/print/{id}', [PracticeController::class, 'print'])->name('print');
});

Route::get('practices/api/exercises', [ExerciseController::class, 'getExerciseAutocomplete']);

