<?php

namespace App\Livewire;

use App\Models\Game;
use App\Models\Player;
use App\Models\User;
use App\Services\RatingService;
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

    public function mount(Game $game, RatingService $ratingService): void
    {
        $this->game = $game;
        /** @var User $user */
        $user = Auth::user();
        $this->players = $user->players()->orderBy('lastname')->get();

        $data = $ratingService->loadRatingsForPlayers($this->players, null, $this->game->id);
        $this->ratings = $data['ratings'];
        $this->attendances = $data['attendances'];
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

    public function saveRatings(RatingService $ratingService): void
    {
        if ($this->players === null) {
            return;
        }

        $ratingService->saveRatings(
            $this->players,
            $this->ratings,
            $this->attendances,
            null,
            $this->game->id
        );

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
