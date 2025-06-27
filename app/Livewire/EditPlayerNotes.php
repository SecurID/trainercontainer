<?php

namespace App\Livewire;

use App\Models\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class EditPlayerNotes extends Component
{
    public Player $player;
    public string $notes;

    public function mount(Player $player): void
    {
        $this->player = $player;
        $this->notes = $player->notes;
    }

    public function save(): void
    {
        $this->player->notes = $this->notes;
        $this->player->save();
        $this->dispatch('saved');
    }

    public function render(): View
    {
        return view('livewire.edit-player-notes');
    }
}
