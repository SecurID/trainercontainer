<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Practice;
use App\Models\Rating;

class PracticeRatingsTable extends Component
{
    public Practice $practice;
    public $players;
    public $ratings = [];
    public $attendances = [];
    public $success = false;
    public $isCollapsed = true;

    public function mount(Practice $practice): void
    {
        $this->practice = $practice;
        $this->players = Auth::user()->players()->get()->sortBy('lastname');
        foreach ($this->players as $player) {
            $rating = Rating::where('practice_id', $this->practice->id)
                ->where('player_id', $player->id)
                ->first();
            $this->ratings[$player->id] = $rating?->rating;
            $this->attendances[$player->id] = $rating?->attended;
        }
    }

    public function saveRatings(): void
    {
        foreach ($this->players as $player) {
            $ratingValue = $this->ratings[$player->id] ?? null;
            $attended = $this->attendances[$player->id];
            // Korrekte Typen für Boolean und Integer
            if ($attended === '1' || $attended === 1 || $attended === true) {
                $attended = true;
            } elseif ($attended === '0' || $attended === 0 || $attended === false) {
                $attended = false;
            } else {
                $attended = null;
            }
            if ($attended === false) {
                $ratingValue = null;
            }
            Rating::updateOrCreate(
                [
                    'practice_id' => $this->practice->id,
                    'player_id' => $player->id,
                    'user_id' => Auth::id(),
                ],
                [
                    'rating' => $ratingValue,
                    'attended' => $attended,
                ]
            );
        }
        $this->success = true;
    }

    public function toggleCollapse(): void
    {
        $this->isCollapsed = !$this->isCollapsed;
    }

    public function render()
    {
        return view('livewire.practice-ratings-table');
    }
}
