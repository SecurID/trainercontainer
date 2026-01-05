<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PlayersList extends Component
{
    public string $search = '';

    public function render(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $query = $user->players();

        if (! empty($this->search)) {
            $query->where(function ($q): void {
                $q->where('prename', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('lastname', 'LIKE', '%'.$this->search.'%');
            });
        }

        $players = $query->orderBy('players.lastname')->get();

        return view('livewire.players-list', compact('players'));
    }
}
