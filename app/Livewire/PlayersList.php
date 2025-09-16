<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PlayersList extends Component
{
    public string $search = '';

    public function render()
    {
        $query = Auth::user()->players();

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('prename', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('lastname', 'LIKE', '%'.$this->search.'%');
            });
        }

        $players = $query->orderBy('players.lastname')->get();

        return view('livewire.players-list', compact('players'));
    }
}
