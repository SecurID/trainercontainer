<?php

namespace App\Livewire;

use App\Models\Player;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class EditPlayerName extends Component
{
    public Player $player;

    public string $prename = '';

    public string $lastname = '';

    public function mount(Player $player): void
    {
        $this->player = $player;
        $this->prename = $player->prename ?? '';
        $this->lastname = $player->lastname ?? '';
    }

    public function save(): RedirectResponse|Redirector
    {
        abort_if($this->player->user_id !== Auth::id(), Response::HTTP_FORBIDDEN);

        /** @var array<string, string> $validated */
        $validated = $this->validate([
            'prename' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
        ]);

        $this->player->update($validated);

        $this->dispatch('saved');
        session()->flash('success-message', __('Player name updated!'));

        return redirect()->route('players.show', $this->player);
    }

    public function render(): View
    {
        return view('livewire.edit-player-name');
    }
}
