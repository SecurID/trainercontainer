<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Practice;
use App\Models\Player;
use App\Models\Rating;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CreateRating extends Component
{
    public $practices;
    public $players;
    public $selectedPractice;
    public $ratings = [];

    public function mount()
    {
        $userId = Auth::id();
        $this->practices = Practice::where('user_id', $userId)
            ->orderBy('date', 'asc')
            ->get();
        $this->players = Player::where('user_id', $userId)
            ->orderBy('lastname', 'asc')
            ->get();
        // Nächste zukünftige Practice vorauswählen
        $next = $this->practices->firstWhere(fn($p) => $p->date >= now());
        $this->selectedPractice = $next ? $next->id : ($this->practices->first()->id ?? null);
    }

    public function save()
    {
        $practiceId = $this->selectedPractice;
        foreach ($this->ratings as $playerId => $ratingValue) {
            Rating::create([
                'practice_id' => $practiceId,
                'player_id' => $playerId,
                'user_id' => Auth::id(),
                'rating' => $ratingValue,
                'date' => Practice::find($practiceId)->date,
            ]);
        }
        session()->flash('success', 'Bewertungen gespeichert!');
        return redirect()->route('players.index');
    }

    public function render()
    {
        return view('livewire.create-rating');
    }
}
