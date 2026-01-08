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

    /** @var array<int, string> */
    public array $exerciseSearchTerms = [];

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
        $newIndex = count($this->rows);
        $this->rows[$newIndex] = [
            'exerciseId' => '',
            'coaches' => '',
            'playerCount' => '',
            'goalkeeperCount' => '',
            'time' => '',
        ];
        $this->exerciseSearchTerms[$newIndex] = '';
    }

    public function removeRow(int $index): void
    {
        unset($this->rows[$index]);
        unset($this->exerciseSearchTerms[$index]);
        $this->rows = array_values($this->rows);
        $this->exerciseSearchTerms = array_values($this->exerciseSearchTerms);
    }

    public function selectExercise(int $rowIndex, int $exerciseId): void
    {
        $exercise = Exercise::query()->find($exerciseId);

        if (! $exercise instanceof Exercise) {
            return;
        }

        $this->rows[$rowIndex]['exerciseId'] = (string) $exerciseId;
        $this->exerciseSearchTerms[$rowIndex] = $exercise->name;

        // Auto-fill exercise defaults if fields are empty
        if ($exercise->playerCount && empty($this->rows[$rowIndex]['playerCount'])) {
            $this->rows[$rowIndex]['playerCount'] = $exercise->playerCount;
        }
        if ($exercise->goalkeeperCount !== null && empty($this->rows[$rowIndex]['goalkeeperCount'])) {
            $this->rows[$rowIndex]['goalkeeperCount'] = $exercise->goalkeeperCount;
        }
        if ($exercise->duration !== null && empty($this->rows[$rowIndex]['time'])) {
            $this->rows[$rowIndex]['time'] = $exercise->duration;
        }
    }

    /**
     * @return Collection<int, Exercise>
     */
    public function getFilteredExercises(int $rowIndex): Collection
    {
        $searchTerm = $this->exerciseSearchTerms[$rowIndex] ?? '';

        if (strlen($searchTerm) < 1) {
            return $this->exercises;
        }

        return $this->exercises->filter(function (Exercise $exercise) use ($searchTerm) {
            return str_contains(strtolower($exercise->name), strtolower($searchTerm));
        });
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
