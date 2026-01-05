<?php

namespace App\Livewire;

use App\Models\Practice;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EditPractice extends Component
{
    use AuthorizesRequests;

    public Practice $practice;

    public string $topic = '';

    public string $date = '';

    public string $successMessage = '';

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

    public function setNotesContent(?string $content): void
    {
        Log::info('setNotesContent called', [
            'practice_id' => $this->practice->id,
            'content_received' => $content,
            'content_length' => strlen($content ?? ''),
        ]);

        $this->notes = $content ?? '';
        $this->practice->update(['notes' => $this->notes]);
        $this->showSuccessMessage();
    }

    public function saveNotes(): void
    {
        Log::info('SaveNotes called', [
            'practice_id' => $this->practice->id,
            'notes_content' => $this->notes,
            'notes_length' => strlen($this->notes),
        ]);

        $this->practice->update(['notes' => $this->notes]);
        $this->showSuccessMessage();
    }

    private function showSuccessMessage(): void
    {
        $this->successMessage = 'Gespeichert!';
    }

    public function clearSuccessMessage(): void
    {
        $this->successMessage = '';
    }

    public function render(): View
    {
        return view('livewire.edit-practice');
    }
}
