<?php

namespace App\Livewire;

use App\Models\Player;
use App\Models\Practice;
use App\Models\Rating;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PlayerPracticeRating extends Component
{
    public Player $player;

    public Practice $practice;

    public string|int|null $value = null;

    public ?int $ratingId = null;

    public function mount(Player $player, Practice $practice): void
    {
        $this->player = $player;
        $this->practice = $practice;
        $rating = Rating::query()->where('player_id', $player->id)
            ->where('practice_id', $practice->id)
            ->first();
        $this->value = $rating?->rating;
        $this->ratingId = $rating?->id;
    }

    public function save(): void
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
                'rating' => $this->value,
            ]
        );
        $this->ratingId = $rating->id;
        session()->flash('success', 'Bewertung gespeichert!');
    }

    public function render(): View
    {
        return view('livewire.player-practice-rating');
    }
}
