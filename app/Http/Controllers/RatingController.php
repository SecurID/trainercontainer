<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $players = Player::all()->sortBy('name');

        return response()->view('ratings/create-ratings', ['players' => $players]);
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', 'date']);
        $date = $request->date;
        foreach($data as $key=>$entry){
            $rating = new Rating();
            $rating->date = $date;
            $split = str_split($key, 6);
            $rating->player_id = $split[1];
            $rating->rating = $entry;
            $rating->save();
        }
        return redirect()->route('players.index');
    }
}
