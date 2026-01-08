<?php

namespace App\Livewire;

use App\Models\Position;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreatePlayer extends Component
{
    public string $prename = '';

    public string $lastname = '';

    public ?int $main_position_id = null;

    /** @var array<int, int> */
    public array $sub_position_ids = [];

    public function save(): void
    {
        $this->validate([
            'prename' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'main_position_id' => 'nullable|exists:positions,id',
            'sub_position_ids' => 'array',
            'sub_position_ids.*' => 'exists:positions,id',
        ]);

        /** @var User $user */
        $user = auth()->user();
        $player = $user->players()->create([
            'prename' => $this->prename,
            'lastname' => $this->lastname,
            'main_position_id' => $this->main_position_id,
        ]);

        if (! empty($this->sub_position_ids)) {
            $player->subPositions()->attach($this->sub_position_ids);
        }

        session()->flash('message', __('messages.player_created'));

        $this->reset(['prename', 'lastname', 'main_position_id', 'sub_position_ids']);
    }

    public function render(): View
    {
        $positions = Position::all();

        return view('livewire.create-player', compact('positions'));
    }
}
