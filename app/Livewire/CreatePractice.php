<?php

namespace App\Livewire;

use App\Models\Exercise;
use App\Models\Practice;
use App\Models\User;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class CreatePractice extends Component
{
    public string $date = '';

    public string $topic = '';

    /** @var array<int, array<string, mixed>> */
    public array $rows = [];

    public string $searchTerm = '';

    /** @var array<int, array<string, mixed>> */
    public array $searchResults = [];

    public ?int $activeRowIndex = null;

    public function mount(): void
    {
        $this->date = date('d.m.Y');
        $this->addRow();
    }

    public function render(): View
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
            'time' => '',
        ];
    }

    public function removeRow(int $index): void
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
    }

    public function setActiveRow(int $index): void
    {
        $this->activeRowIndex = $index;
    }

    public function search(): void
    {
        if (strlen($this->searchTerm) >= 2) {
            /** @var array<int, array<string, mixed>> $results */
            $results = Exercise::query()->where('name', 'like', '%'.$this->searchTerm.'%')
                ->limit(4)
                ->get()
                ->toArray();
            $this->searchResults = $results;
        } else {
            $this->searchResults = [];
        }
    }

    public function selectExercise(int $exerciseId, string $exerciseName): void
    {
        if ($this->activeRowIndex !== null) {
            $this->rows[$this->activeRowIndex]['exercise'] = $exerciseName;
            $this->rows[$this->activeRowIndex]['exerciseId'] = $exerciseId;
            $this->searchTerm = '';
            $this->searchResults = [];
            $this->activeRowIndex = null;
        }
    }

    public function updateSearchTerm(string $value): void
    {
        $this->searchTerm = $value;
        $this->search();
    }

    public function save(): RedirectResponse|Redirector
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

        /** @var User $user */
        $user = Auth::user();
        $practice = new Practice([
            'date' => DateTime::createFromFormat('d.m.Y', $this->date),
            'topic' => $this->topic,
            'user_id' => $user->id,
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
