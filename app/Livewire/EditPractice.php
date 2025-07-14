<?php

namespace App\Livewire;

use App\Models\Practice;
use Livewire\Component;

class EditPractice extends Component
{
    public Practice $practice;
    public string $topic;
    public $date;
    public string $successMessage = '';
    public ?int $playerCount;
    public ?int $goalkeeperCount;

    public function mount(Practice $practice): void
    {
        $this->practice = $practice;
        $this->topic = $practice->topic;
        $this->date = $practice->date->format('Y-m-d');
        $this->playerCount = $practice->playerCount;
        $this->goalkeeperCount = $practice->goalkeeperCount;
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

    private function showSuccessMessage(): void
    {
        $this->successMessage = 'Gespeichert!';
    }
    
    public function clearSuccessMessage(): void
    {
        $this->successMessage = '';
    }

    public function render()
    {
        return view('livewire.edit-practice');
    }
}
