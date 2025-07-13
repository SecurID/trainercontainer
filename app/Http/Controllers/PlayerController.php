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
        $player->load(['mainPosition', 'subPositions']);
        
        $ratings = $player->ratings()->get()->sortBy('date');
        $labels = [];
        $ratings_array = [];
        foreach($ratings as $rating){
            $dateFormatted = $rating->practice->date->format('d.m.Y');
            $labels[] = $dateFormatted;
            $ratings_array[] = $rating->rating;
        }

        return response()->view('players/player-single', ['player' => $player, 'ratings' => $ratings, 'labels' => $labels, 'ratings_array' => $ratings_array]);
    }
}
