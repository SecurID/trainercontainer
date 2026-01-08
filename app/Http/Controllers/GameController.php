<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = Auth::user();
        $games = Game::query()->where('user_id', $user->id)
            ->orderBy('date')
            ->get();

        return response()->view('games/games', ['games' => $games]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        /** @var User $user */
        $user = Auth::user();
        $opponents = $user->opponents()->orderBy('name')->get();
        $formations = Game::FORMATIONS;

        return response()->view('games/create-game', ['opponents' => $opponents, 'formations' => $formations]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var array{opponent_id: int, opponent_formation: ?string, date: string, time: ?string, location: ?string, notes: ?string} $data */
        $data = $request->validate([
            'opponent_id' => 'required|exists:opponents,id',
            'opponent_formation' => 'nullable|string|in:'.implode(',', Game::FORMATIONS),
            'date' => 'required|date',
            'time' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $game = new Game([
            'opponent_id' => $data['opponent_id'],
            'opponent_formation' => $data['opponent_formation'] ?? null,
            'date' => $data['date'],
            'time' => $data['time'] ?? null,
            'location' => $data['location'] ?? null,
            'notes' => $data['notes'] ?? null,
            'user_id' => $user->id,
        ]);
        $game->save();

        return redirect()->route('games.index')->with('success-message', __('messages.game_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game): Response
    {
        $this->authorize('view', $game);

        /** @var User $user */
        $user = Auth::user();
        $players = $user->players()->orderBy('lastname')->get();

        return response()->view('games/game-single', [
            'game' => $game,
            'players' => $players,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game): Response
    {
        $this->authorize('update', $game);

        /** @var User $user */
        $user = Auth::user();
        $opponents = $user->opponents()->orderBy('name')->get();
        $formations = Game::FORMATIONS;

        return response()->view('games/edit-game', ['game' => $game, 'opponents' => $opponents, 'formations' => $formations]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game): RedirectResponse
    {
        $this->authorize('update', $game);

        /** @var array{opponent_id: int, opponent_formation: ?string, date: string, time: ?string, location: ?string, notes: ?string} $data */
        $data = $request->validate([
            'opponent_id' => 'required|exists:opponents,id',
            'opponent_formation' => 'nullable|string|in:'.implode(',', Game::FORMATIONS),
            'date' => 'required|date',
            'time' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $game->update($data);

        return redirect()->route('games.index')->with('success-message', __('messages.game_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game): RedirectResponse
    {
        $this->authorize('delete', $game);

        $game->delete();

        return redirect()->route('games.index')->with('success-message', __('messages.game_deleted'));
    }
}
