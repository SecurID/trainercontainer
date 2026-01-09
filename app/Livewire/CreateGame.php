<?php

namespace App\Livewire;

use App\Models\Game;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class CreateGame extends Component
{
    public ?int $opponent_id = null;

    public ?string $opponent_formation = null;

    public ?string $date = null;

    public ?string $time = null;

    public ?string $location = null;

    public ?string $notes = null;

    public function mount(): void
    {
        $this->date = date('Y-m-d');
    }

    public function render(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $opponents = $user->opponents()->orderBy('name')->get();
        $formations = Game::FORMATIONS;

        return view('livewire.create-game', compact('opponents', 'formations'));
    }

    public function save(): RedirectResponse|Redirector
    {
        $this->validate([
            'opponent_id' => 'required|exists:opponents,id',
            'opponent_formation' => 'nullable|string|in:'.implode(',', Game::FORMATIONS),
            'date' => 'required|date',
            'time' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $game = new Game([
            'opponent_id' => $this->opponent_id,
            'opponent_formation' => $this->opponent_formation,
            'date' => $this->date,
            'time' => $this->time,
            'location' => $this->location,
            'notes' => $this->notes,
            'user_id' => $user->id,
        ]);
        $game->save();

        Flux::toast(__('messages.game_created'));

        return redirect()->route('games.index');
    }
}
