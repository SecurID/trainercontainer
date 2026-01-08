<?php

namespace App\Livewire;

use App\Models\Player;
use App\Models\Practice;
use App\Models\User;
use App\Services\RatingService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PracticeRatingsTable extends Component
{
    public Practice $practice;

    /** @var Collection<int, Player>|null */
    public ?Collection $players = null;

    /** @var array<int, int|null> */
    public array $ratings = [];

    /** @var array<int, bool> */
    public array $attendances = [];

    public bool $success = false;

    /** @var array<string, string> */
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount(Practice $practice, RatingService $ratingService): void
    {
        $this->practice = $practice;
        /** @var User $user */
        $user = Auth::user();
        $this->players = $user->players()->orderBy('lastname')->get();

        $data = $ratingService->loadRatingsForPlayers($this->players, $this->practice->id, null);
        $this->ratings = $data['ratings'];
        $this->attendances = $data['attendances'];
    }

    public function updatedRatings(mixed $value, int|string|null $playerId = null): void
    {
        // When entire array is set, $playerId is null - skip individual logic
        if ($playerId === null) {
            return;
        }

        // If a rating is selected, mark as attended
        if ($value) {
            $this->attendances[(int) $playerId] = false;
        }
    }

    public function updatedAttendances(mixed $value, int|string|null $playerId = null): void
    {
        // When entire array is set, $playerId is null - skip individual logic
        if ($playerId === null) {
            return;
        }

        // If marked as not attended, clear the rating
        if ($value) {
            $this->ratings[(int) $playerId] = null;
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
            $this->practice->id,
            null
        );

        $this->success = true;
    }

    public function render(): View
    {
        return view('livewire.practice-ratings-table');
    }
}
