<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Auth::user()->players()->orderBy('players.lastname')->get();

        return response()->view('players/players', ['players' => $players]);
    }

    public function create()
    {
        return response()->view('players/create-player');
    }

    public function show(Player $player)
    {
        $lastmonth = Carbon::now()->subMonth();
        $ratings = $player->ratings()->where('date','>', $lastmonth)->get()->sortBy('date');
        $labels = [];
        $ratings_array = [];
        foreach($ratings as $rating){
            $dateFormatted = Carbon::createFromFormat('Y-m-d', $rating->date)->format('d.m.Y');
            $labels[] = $dateFormatted;
            $ratings_array[] = $rating->rating;
        }

        return response()->view('players/player-single', ['player' => $player, 'ratings' => $ratings, 'labels' => $labels, 'ratings_array' => $ratings_array]);
    }
}
