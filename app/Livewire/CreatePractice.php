<?php

namespace App\Livewire;

use App\Models\Exercise;
use App\Models\Practice;
use App\Models\User;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
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

    /** @var Collection<int, Exercise> */
    public Collection $exercises;

    public function mount(): void
    {
        $this->date = date('d.m.Y');
        $this->exercises = Exercise::query()->orderBy('name')->get();
        $this->addRow();
    }

    public function render(): View
    {
        return view('livewire.create-practice');
    }

    public function addRow(): void
    {
        $this->rows[] = [
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
