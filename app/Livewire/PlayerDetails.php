<?php

namespace App\Livewire;

use App\Models\Player;
use App\Models\Position;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;

class PlayerDetails extends Component
{
    use AuthorizesRequests;

    public Player $player;

    public string $prename = '';

    public string $lastname = '';

    public ?int $main_position_id = null;

    /** @var array<int, int> */
    public array $sub_position_ids = [];

    public ?string $notes = null;

    /** @var Collection<int, Position> */
    public Collection $positions;

    public function mount(Player $player): void
    {
        $this->player = $player;
        $this->positions = Position::all();
        $this->loadPlayerData();
    }

    private function loadPlayerData(): void
    {
        $this->player->refresh();
        $this->player->load(['mainPosition', 'subPositions']);

        $this->prename = $this->player->prename ?? '';
        $this->lastname = $this->player->lastname ?? '';
        $this->main_position_id = $this->player->main_position_id;
        /** @var array<int, int> $subPositionIds */
        $subPositionIds = $this->player->subPositions->pluck('id')->toArray();
        $this->sub_position_ids = $subPositionIds;
        $this->notes = $this->player->notes;
    }

    public function saveName(): void
    {
        $this->authorize('update', $this->player);

        $validated = $this->validate([
            'prename' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
        ]);

        $this->player->update($validated);
        $this->loadPlayerData();

        Flux::toast(__('Player name updated!'));
        Flux::modal('edit-player-name')->close();
        $this->dispatch('player-name-updated', name: $this->player->getFullname());
    }

    public function savePositions(): void
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
        $this->loadPlayerData();

        Flux::toast(__('Positions updated!'));
        Flux::modal('edit-player-positions')->close();
    }

    public function saveNotes(): void
    {
        $this->authorize('update', $this->player);

        $this->player->notes = $this->notes;
        $this->player->save();
        $this->loadPlayerData();

        Flux::toast(__('Notes updated!'));
        Flux::modal('edit-player-notes')->close();
    }

    #[On('player-name-updated')]
    public function refreshPlayer(): void
    {
        $this->loadPlayerData();
    }

    public function render(): View
    {
        return view('livewire.player-details');
    }
}
