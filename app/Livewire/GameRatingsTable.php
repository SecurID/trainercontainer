<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Game;
use App\Models\Rating;

class GameRatingsTable extends Component
{
    public Game $game;
    public $players;
    public $ratings = [];
    public $attendances = [];
    public $success = false;
    public $isCollapsed = true;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount(Game $game): void
    {
        $this->game = $game;
        $this->players = Auth::user()->players()->get()->sortBy('lastname');
        foreach ($this->players as $player) {
            $rating = Rating::where('game_id', $this->game->id)
                ->where('player_id', $player->id)
                ->first();
            $this->ratings[$player->id] = $rating?->rating;
            $this->attendances[$player->id] = $rating?->attended === false ? true : false; // Invert for checkbox logic
        }
    }

    public function updatedRatings($value, $playerId)
    {
        // If a rating is selected, mark as attended
        if ($value) {
            $this->attendances[$playerId] = false;
        }
    }

    public function updatedAttendances($value, $playerId)
    {
        // If marked as not attended, clear the rating
        if ($value) {
            $this->ratings[$playerId] = null;
        }
    }

    public function saveRatings(): void
    {
        foreach ($this->players as $player) {
            $ratingValue = $this->ratings[$player->id] ?? null;
            $attended = $this->attendances[$player->id];
            // Korrekte Typen für Boolean und Integer
            if ($attended === '1' || $attended === 1 || $attended === true) {
                $attended = false; // Not attended
                $ratingValue = null; // Clear rating when not attended
            } elseif ($attended === '0' || $attended === 0 || $attended === false || $attended === null) {
                $attended = true; // Attended
            }
            Rating::updateOrCreate(
                [
                    'game_id' => $this->game->id,
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
        return view('livewire.game-ratings-table');
    }
}
