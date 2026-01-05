<?php

namespace App\Livewire;

use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateGame extends Component
{
    public $opponent_id;

    public $opponent_formation;

    public $date;

    public $time;

    public $location;

    public $notes;

    public function mount(): void
    {
        $this->date = date('Y-m-d');
    }

    public function render()
    {
        $opponents = Auth::user()->opponents()->orderBy('name')->get();
        $formations = Game::FORMATIONS;

        return view('livewire.create-game', compact('opponents', 'formations'));
    }

    public function save()
    {
        $this->validate([
            'opponent_id' => 'required|exists:opponents,id',
            'opponent_formation' => 'nullable|string|in:'.implode(',', Game::FORMATIONS),
            'date' => 'required|date',
            'time' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $game = new Game([
            'opponent_id' => $this->opponent_id,
            'opponent_formation' => $this->opponent_formation,
            'date' => $this->date,
            'time' => $this->time,
            'location' => $this->location,
            'notes' => $this->notes,
            'user_id' => Auth::user()->id,
        ]);
        $game->save();

        session()->flash('success-message', 'Spiel erfolgreich erstellt!');

        return redirect()->route('games.index');
    }
}
