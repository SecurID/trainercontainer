<?php

namespace App\Livewire;

use App\Models\Player;
use App\Models\Practice;
use App\Models\Rating;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class CreateRating extends Component
{
    /** @var Collection<int, Practice>|null */
    public ?Collection $practices = null;

    /** @var Collection<int, Player>|null */
    public ?Collection $players = null;

    public ?int $selectedPractice = null;

    /** @var array<int, int|null> */
    public array $ratings = [];

    public function mount(): void
    {
        $userId = Auth::id();
        $this->practices = Practice::query()->where('user_id', $userId)
            ->orderBy('date', 'asc')
            ->get();
        $this->players = Player::query()->where('user_id', $userId)
            ->orderBy('lastname', 'asc')
            ->get();
        // Select next future practice
        $next = $this->practices->firstWhere(fn ($p) => $p->date >= now());
        $this->selectedPractice = $next?->id ?? $this->practices->first()?->id;
    }

    public function save(): RedirectResponse|Redirector
    {
        $practiceId = $this->selectedPractice;
        foreach ($this->ratings as $playerId => $ratingValue) {
            $practice = Practice::query()->find($practiceId);
            Rating::create([
                'practice_id' => $practiceId,
                'player_id' => $playerId,
                'user_id' => Auth::id(),
                'rating' => $ratingValue,
                'date' => $practice?->date,
            ]);
        }
        session()->flash('success', __('messages.ratings_saved'));

        return redirect()->route('players.index');
    }

    public function render(): View
    {
        return view('livewire.create-rating');
    }
}
