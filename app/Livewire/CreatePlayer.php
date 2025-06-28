<?php

namespace App\Livewire;

use Livewire\Component;

class CreatePlayer extends Component
{
    public string $prename = '';

    public string $lastname = '';

    public function save(): void
    {
        $this->validate([
            'prename' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->players()->create([
            'prename' => $this->prename,
            'lastname' => $this->lastname,
        ]);

        session()->flash('message', 'Player created successfully.');

        $this->reset(['prename', 'lastname']);
    }

    public function render()
    {
        return view('livewire.create-player');
    }
}
