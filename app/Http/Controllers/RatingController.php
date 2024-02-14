<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RatingController extends Controller
{
    public function index()
    {
        $players = Player::where('user_id', auth()->id())->get()->sortBy('name');

        return response()->view('ratings/create-ratings', ['players' => $players]);
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', 'date']);
        // Convert the date from DD.MM.YYYY to YYYY-MM-DD
        $date = Carbon::createFromFormat('d.m.Y', $request->date)->format('Y-m-d');

        foreach($data as $key => $entry){
            $rating = new Rating();
            $rating->date = $date; // Use the converted date
            $split = str_split($key, 6);
            $rating->player_id = $split[1];
            $rating->user_id = auth()->id();
            $rating->rating = $entry;
            $rating->save();
        }

        return redirect()->route('players.index');
    }

}
