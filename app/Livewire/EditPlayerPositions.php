<?php

namespace App\Livewire;

use App\Models\Player;
use App\Models\Position;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class EditPlayerPositions extends Component
{
    use AuthorizesRequests;

    public Player $player;

    public ?int $main_position_id = null;

    /** @var array<int, int> */
    public array $sub_position_ids = [];

    public function mount(Player $player): void
    {
        $this->authorize('update', $player);

        $this->player = $player;
        $this->main_position_id = $player->main_position_id;
        /** @var array<int, int> $subPositionIds */
        $subPositionIds = $player->subPositions->pluck('id')->toArray();
        $this->sub_position_ids = $subPositionIds;
    }

    public function save(): void
    {
        $this->authorize('update', $this->player);

        $this->validate([
            'main_position_id' => 'nullable|exists:positions,id',
            'sub_position_ids' => 'array',
            'sub_position_ids.*' => 'exists:positions,id',
        ]);

        $this->player->update([
            'main_position_id' => $this->main_position_id,
        ]);

        $this->player->subPositions()->sync($this->sub_position_ids);

        $this->dispatch('saved');
    }

    public function render(): View
    {
        $positions = Position::all();

        return view('livewire.edit-player-positions', compact('positions'));
    }
}
