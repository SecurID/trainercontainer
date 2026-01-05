<?php

namespace App\Livewire;

use App\Models\Player;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class EditPlayerNotes extends Component
{
    use AuthorizesRequests;

    public Player $player;

    public ?string $notes = null;

    public function mount(Player $player): void
    {
        $this->authorize('update', $player);

        $this->player = $player;
        $this->notes = $player->notes;
    }

    public function save(): void
    {
        $this->authorize('update', $this->player);

        $this->player->notes = $this->notes;
        $this->player->save();
        $this->dispatch('saved');
    }

    public function render(): View
    {
        return view('livewire.edit-player-notes');
    }
}
