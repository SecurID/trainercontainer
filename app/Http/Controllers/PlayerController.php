<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $players = $user->players()->orderBy('players.name')->get();

        return response()->view('players/players', ['players' => $players]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('players/create-player');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $player = new Player();
        $player->name = $request->name;
        $player->prename = $request->prename;
        $player->user_id = Auth::id();
        $player->save();

        return redirect()->route('players.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $player = Player::find($id);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
