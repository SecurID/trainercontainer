<?php

namespace App\Livewire;

use App\Models\Practice;
use Livewire\Component;

class EditPractice extends Component
{
    public Practice $practice;
    public $topic;
    public $date;
    public $successMessage = '';

    public function mount(Practice $practice): void
    {
        $this->practice = $practice;
        $this->topic = $practice->topic;
        $this->date = $practice->date->format('Y-m-d');
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

    private function showSuccessMessage(): void
    {
        $this->successMessage = 'Gespeichert!';
        $this->dispatch('success-message');
    }

    public function render()
    {
        return view('livewire.edit-practice');
    }
}
