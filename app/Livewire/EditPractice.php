<?php

namespace App\Livewire;

use App\Models\Practice;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class EditPractice extends Component
{
    use AuthorizesRequests;

    public Practice $practice;

    public string $topic = '';

    public string $date = '';

    public ?int $playerCount = null;

    public ?int $goalkeeperCount = null;

    public string $notes = '';

    public function mount(Practice $practice): void
    {
        $this->authorize('update', $practice);

        $this->practice = $practice;
        $this->topic = $practice->topic ?? '';
        /** @var \Carbon\Carbon $practiceDate */
        $practiceDate = $practice->date;
        $this->date = $practiceDate->format('Y-m-d');
        $this->playerCount = $practice->playerCount;
        $this->goalkeeperCount = $practice->goalkeeperCount;
        $this->notes = $practice->notes ?? '';
    }

    public function updatedTopic(): void
    {
        $this->practice->update(['topic' => $this->topic]);
        $this->showSuccessMessage();
    }

    public function updatedDate(): void
    {
        $this->practice->update(['date' => $this->date]);
        $this->showSuccessMessage();
    }

    public function updatedPlayerCount(): void
    {
        $this->practice->update(['playerCount' => $this->playerCount]);
        $this->showSuccessMessage();
    }

    public function updatedGoalkeeperCount(): void
    {
        $this->practice->update(['goalkeeperCount' => $this->goalkeeperCount]);
        $this->showSuccessMessage();
    }

    public function updatedNotes(): void
    {
        $this->practice->update(['notes' => $this->notes]);
        $this->showSuccessMessage();
    }

    private function showSuccessMessage(): void
    {
        Flux::toast(__('messages.saved'));
    }

    public function render(): View
    {
        return view('livewire.edit-practice');
    }
}
