<?php

namespace App\Livewire;

use Livewire\Component;

class EditPlayerNotes extends Component
{
    public $player;
    public $notes;

    public function mount($player): void
    {
        $this->player = $player;
        $this->notes = $player->notes;
    }

    public function save(): mixed
    {
        $this->player->notes = $this->notes;
        $this->player->save();
        return redirect()->route('players.show', $this->player);
    }

    public function render(): mixed
    {
        return view('livewire.edit-player-notes');
    }
}
