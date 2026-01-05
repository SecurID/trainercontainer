<?php

namespace App\Livewire;

use App\Models\Game;
use App\Models\Player;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GameRatingsTable extends Component
{
    public Game $game;

    /** @var Collection<int, Player>|null */
    public ?Collection $players = null;

    /** @var array<int, int|null> */
    public array $ratings = [];

    /** @var array<int, bool> */
    public array $attendances = [];

    public bool $success = false;

    public bool $isCollapsed = true;

    /** @var array<string, string> */
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount(Game $game): void
    {
        $this->game = $game;
        /** @var User $user */
        $user = Auth::user();
        $this->players = $user->players()->get()->sortBy('lastname');
        foreach ($this->players as $player) {
            $rating = Rating::query()->where('game_id', $this->game->id)
                ->where('player_id', $player->id)
                ->first();
            $this->ratings[$player->id] = $rating?->rating;
            $this->attendances[$player->id] = $rating?->attended === false;
        }
    }

    public function updatedRatings(mixed $value, int $playerId): void
    {
        // If a rating is selected, mark as attended
        if ($value) {
            $this->attendances[$playerId] = false;
        }
    }

    public function updatedAttendances(mixed $value, int $playerId): void
    {
        // If marked as not attended, clear the rating
        if ($value) {
            $this->ratings[$playerId] = null;
        }
    }

    public function saveRatings(): void
    {
        if ($this->players === null) {
            return;
        }

        foreach ($this->players as $player) {
            $ratingValue = $this->ratings[$player->id] ?? null;
            $attended = $this->attendances[$player->id] ?? false;
            // Correct types for Boolean and Integer
            if ($attended === true) {
                $attended = false; // Not attended
                $ratingValue = null; // Clear rating when not attended
            } else {
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
        $this->isCollapsed = ! $this->isCollapsed;
    }

    public function render(): View
    {
        return view('livewire.game-ratings-table');
    }
}
