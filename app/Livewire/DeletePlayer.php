<?php

namespace App\Livewire;

use App\Models\Player;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeletePlayer extends Component
{
    public Player $player;

    public bool $confirmingDeletion = false;

    public function confirmDeletion(): void
    {
        $this->confirmingDeletion = true;
    }

    public function cancelDeletion(): void
    {
        $this->confirmingDeletion = false;
    }

    public function deletePlayer()
    {
        abort_if($this->player->user_id !== Auth::id(), Response::HTTP_FORBIDDEN);

        $this->player->delete();

        session()->flash('success-message', __('Player successfully deleted!'));

        return redirect()->route('players.index');
    }

    public function render(): View
    {
        return view('livewire.delete-player');
    }
}
