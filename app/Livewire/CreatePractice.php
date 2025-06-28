<?php

namespace App\Livewire;

use App\Models\Exercise;
use App\Models\Practice;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreatePractice extends Component
{
    public $date;
    public $topic;
    public $rows = [];
    public $searchTerm = '';
    public $searchResults = [];
    public $activeRowIndex = null;

    public function mount(): void
    {
        $this->date = date('d.m.Y');
        $this->addRow();
    }

    public function render()
    {
        return view('livewire.create-practice');
    }

    public function addRow(): void
    {
        $this->rows[] = [
            'exercise' => '',
            'exerciseId' => '',
            'coaches' => '',
            'playerCount' => '',
            'goalkeeperCount' => '',
            'time' => ''
        ];
    }

    public function removeRow($index): void
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
    }

    public function setActiveRow($index): void
    {
        $this->activeRowIndex = $index;
    }

    public function search(): void
    {
        if (strlen($this->searchTerm) >= 2) {
            $this->searchResults = Exercise::where('name', 'like', '%' . $this->searchTerm . '%')
                ->limit(4)
                ->get()
                ->toArray();
        } else {
            $this->searchResults = [];
        }
    }

    public function selectExercise($exerciseId, $exerciseName): void
    {
        if ($this->activeRowIndex !== null) {
            $this->rows[$this->activeRowIndex]['exercise'] = $exerciseName;
            $this->rows[$this->activeRowIndex]['exerciseId'] = $exerciseId;
            $this->searchTerm = '';
            $this->searchResults = [];
            $this->activeRowIndex = null;
        }
    }

    public function updateSearchTerm($value): void
    {
        $this->searchTerm = $value;
        $this->search();
    }

    public function save()
    {
        $this->validate([
            'date' => 'required|string',
            'topic' => 'required|string',
            'rows.*.exerciseId' => 'required',
            'rows.*.coaches' => 'required|string',
            'rows.*.time' => 'required|string',
            'rows.*.playerCount' => 'required',
            'rows.*.goalkeeperCount' => 'required',
        ]);

        $practice = new Practice([
            'date' => DateTime::createFromFormat('d.m.Y', $this->date),
            'topic' => $this->topic,
            'user_id' => Auth::user()->id,
        ]);
        $practice->save();

        foreach ($this->rows as $row) {
            $practice->schedules()->create([
                'exercise_id' => $row['exerciseId'],
                'coaches' => $row['coaches'],
                'time' => $row['time'],
                'playerCount' => $row['playerCount'],
                'goalkeeperCount' => $row['goalkeeperCount'],
            ]);
        }

        return redirect()->route('practices.index');
    }
}
