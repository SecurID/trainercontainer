<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Player;
use App\Models\Practice;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $player = Player::where('user_id', Auth::id())->first();
        $exercise = Exercise::where('user_id', Auth::id())->first();
        $practice = Practice::where('user_id', Auth::id())->first();
        $ratings = Rating::where('user_id', Auth::id())->first();
        return view('dashboard', ['player' => isset($player), 'exercise' => isset($exercise), 'practice' => isset($practice), 'rating' => isset($ratings)]);
    }
}
