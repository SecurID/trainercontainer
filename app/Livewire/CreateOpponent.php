<?php

namespace App\Livewire;

use Livewire\Component;

class CreateOpponent extends Component
{
    public string $name = '';

    public string $notes = '';

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $user = auth()->user();
        $user->opponents()->create([
            'name' => $this->name,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'Opponent created successfully.');

        $this->reset(['name', 'notes']);
    }

    public function render()
    {
        return view('livewire.create-opponent');
    }
}
