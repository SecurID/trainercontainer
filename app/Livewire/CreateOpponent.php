<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
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

        /** @var User $user */
        $user = auth()->user();
        $user->opponents()->create([
            'name' => $this->name,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'Opponent created successfully.');

        $this->reset(['name', 'notes']);
    }

    public function render(): View
    {
        return view('livewire.create-opponent');
    }
}
