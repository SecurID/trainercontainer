<?php

namespace App\Livewire;

use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateGame extends Component
{
    public $opponent;
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
        return view('livewire.create-game');
    }

    public function save()
    {
        $this->validate([
            'opponent' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $game = new Game([
            'opponent' => $this->opponent,
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
