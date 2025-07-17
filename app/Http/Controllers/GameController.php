<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::where('user_id', Auth::user()->id)
            ->orderBy('date')
            ->get();

        return response()->view('games/games', ['games' => $games]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('games/create-game');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'opponent' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $game = new Game([
            'opponent' => $data['opponent'],
            'date' => $data['date'],
            'time' => $data['time'],
            'location' => $data['location'],
            'notes' => $data['notes'],
            'user_id' => Auth::user()->id,
        ]);
        $game->save();

        return redirect()->route('games.index')->with('success-message', 'Game created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        $this->authorize('view', $game);
        
        $players = Auth::user()->players()->get()->sortBy('lastname');
        return response()->view('games/game-single', [
            'game' => $game,
            'players' => $players,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        $this->authorize('update', $game);
        
        return response()->view('games/edit-game', ['game' => $game]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $this->authorize('update', $game);
        
        $data = $request->validate([
            'opponent' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $game->update($data);

        return redirect()->route('games.index')->with('success-message', 'Game updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $this->authorize('delete', $game);
        
        $game->delete();
        return redirect()->route('games.index')->with('success-message', 'Game successfully deleted!');
    }
}
