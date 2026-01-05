<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Player;
use App\Models\Practice;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        $hasPlayer = Player::query()->where('user_id', $userId)->exists();
        $hasExercise = Exercise::query()->where('user_id', $userId)->exists();
        $hasPractice = Practice::query()->where('user_id', $userId)->exists();

        $nextPractice = Practice::query()->where('user_id', $userId)
            ->where('date', '>=', now()->startOfDay())
            ->orderBy('date')
            ->first();

        return view('dashboard', [
            'player' => $hasPlayer,
            'exercise' => $hasExercise,
            'practice' => $hasPractice,
            'nextPractice' => $nextPractice,
        ]);
    }
}
