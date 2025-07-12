<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Player;
use App\Models\Practice;
use App\Models\Rating;

class PlayerPracticeRating extends Component
{
    public Player $player;
    public Practice $practice;
    public $value;
    public $ratingId;

    public function mount(Player $player, Practice $practice)
    {
        $this->player = $player;
        $this->practice = $practice;
        $rating = Rating::where('player_id', $player->id)
            ->where('practice_id', $practice->id)
            ->first();
        $this->value = $rating ? $rating->value : null;
        $this->ratingId = $rating ? $rating->id : null;
    }

    public function save()
    {
        $this->validate([
            'value' => 'required|numeric|min:1|max:10',
        ]);
        $rating = Rating::updateOrCreate(
            [
                'player_id' => $this->player->id,
                'practice_id' => $this->practice->id,
            ],
            [
                'value' => $this->value,
            ]
        );
        $this->ratingId = $rating->id;
        session()->flash('success', 'Bewertung gespeichert!');
    }

    public function render()
    {
        return view('livewire.player-practice-rating');
    }
}
