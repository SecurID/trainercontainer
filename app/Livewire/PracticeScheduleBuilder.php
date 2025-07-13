<?php

namespace App\Livewire;

use App\Models\Practice;
use App\Models\Exercise;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PracticeScheduleBuilder extends Component
{
    public Practice $practice;
    public $scheduleRows = [];
    public $availableExercises = [];
    public $exerciseSearchTerms = [];
    public $showExerciseDropdowns = [];
    public $isCollapsed = true;
    public $successMessage = '';

    protected $rules = [
        'scheduleRows.*.exercise_id' => 'required|exists:exercises,id',
        'scheduleRows.*.playerCount' => 'required|integer|min:1|max:30',
        'scheduleRows.*.goalkeeperCount' => 'nullable|integer|min:0|max:5',
        'scheduleRows.*.time' => 'required|string|max:20',
        'scheduleRows.*.coaches' => 'nullable|string|max:100'
    ];

    public function mount(Practice $practice): void
    {
        $this->practice = $practice;
        $this->loadExistingSchedules();

        if (empty($this->scheduleRows)) {
            $this->addRow();
        }
    }

    public function loadExistingSchedules(): void
    {
        $schedules = $this->practice->schedules()->with('exercise')->get();

        foreach ($schedules as $index => $schedule) {
            $this->scheduleRows[$index] = [
                'id' => $schedule->id,
                'exercise_id' => $schedule->exercise_id,
                'exercise_name' => $schedule->exercise->name ?? '',
                'playerCount' => $schedule->playerCount,
                'goalkeeperCount' => $schedule->goalkeeperCount,
                'time' => $schedule->time,
                'coaches' => $schedule->coaches,
            ];
            $this->exerciseSearchTerms[$index] = $schedule->exercise->name ?? '';
            $this->showExerciseDropdowns[$index] = false;
        }
    }

    public function addRow(): void
    {
        $newIndex = count($this->scheduleRows);
        $this->scheduleRows[$newIndex] = [
            'id' => null,
            'exercise_id' => null,
            'exercise_name' => '',
            'playerCount' => null,
            'goalkeeperCount' => 0,
            'time' => '',
            'coaches' => '',
        ];
        $this->exerciseSearchTerms[$newIndex] = '';
        $this->showExerciseDropdowns[$newIndex] = false;
    }

    public function removeRow($index): void
    {
        if (isset($this->scheduleRows[$index]['id'])) {
            Schedule::find($this->scheduleRows[$index]['id'])?->delete();
        }

        unset($this->scheduleRows[$index]);
        unset($this->exerciseSearchTerms[$index]);
        unset($this->showExerciseDropdowns[$index]);
        unset($this->availableExercises[$index]);

        $this->scheduleRows = array_values($this->scheduleRows);
        $this->exerciseSearchTerms = array_values($this->exerciseSearchTerms);
        $this->showExerciseDropdowns = array_values($this->showExerciseDropdowns);

        $this->showSuccessMessage('Eintrag entfernt!');
    }

    public function updateExerciseSearch($rowIndex, $searchTerm): void
    {
        $this->exerciseSearchTerms[$rowIndex] = $searchTerm;

        if (strlen($searchTerm) >= 1) {
            $this->availableExercises[$rowIndex] = Exercise::where(function($query) use ($searchTerm) {
                    $query->where('name', 'like', "%{$searchTerm}%")
                          ->orWhere('focus', 'like', "%{$searchTerm}%");
                })
                ->orderBy('name')
                ->limit(10)
                ->get();

            $this->showExerciseDropdowns[$rowIndex] = count($this->availableExercises[$rowIndex]) > 0;
        } else {
            $this->showExerciseDropdowns[$rowIndex] = false;
            $this->availableExercises[$rowIndex] = [];
        }
    }

    public function updatedExerciseSearchTerms($value, $key): void
    {
        $this->updateExerciseSearch($key, $value);
    }

    public function showExerciseDropdown($rowIndex): void
    {
        // Show all exercises when input gets focus
        $this->availableExercises[$rowIndex] = Exercise::where('user_id', Auth::id())
            ->orderBy('name')
            ->limit(10)
            ->get();

        $this->showExerciseDropdowns[$rowIndex] = count($this->availableExercises[$rowIndex]) > 0;
    }

    public function hideExerciseDropdown($rowIndex): void
    {
        // Use a delay to allow for clicking on dropdown items
        $this->showExerciseDropdowns[$rowIndex] = false;
    }

    public function selectExercise($rowIndex, $exerciseId): void
    {
        $exercise = Exercise::find($exerciseId);

        $this->scheduleRows[$rowIndex]['exercise_id'] = $exerciseId;
        $this->scheduleRows[$rowIndex]['exercise_name'] = $exercise->name;
        $this->exerciseSearchTerms[$rowIndex] = $exercise->name;

        if ($exercise->playerCount && !$this->scheduleRows[$rowIndex]['playerCount']) {
            $this->scheduleRows[$rowIndex]['playerCount'] = $exercise->playerCount;
        }
        if ($exercise->goalkeeperCount !== null && !$this->scheduleRows[$rowIndex]['goalkeeperCount']) {
            $this->scheduleRows[$rowIndex]['goalkeeperCount'] = $exercise->goalkeeperCount;
        }
        if ($exercise->duration !== null && !$this->scheduleRows[$rowIndex]['time']) {
            $this->scheduleRows[$rowIndex]['time'] = $exercise->duration;
        }

        $this->showExerciseDropdowns[$rowIndex] = false;
        $this->saveScheduleRow($rowIndex);
    }

    public function updatedScheduleRows($value, $key): void
    {
        if (str_contains($key, '.')) {
            [$rowIndex, $field] = explode('.', $key);

            if ($field !== 'exercise_name') {
                $this->saveScheduleRow($rowIndex);
            }
        }
    }

    public function saveScheduleRow($rowIndex): void
    {
        if (!isset($this->scheduleRows[$rowIndex])) {
            $this->showSuccessMessage('Fehler: Zeile nicht gefunden');
            return;
        }

        $row = $this->scheduleRows[$rowIndex];

        // Check required fields
        if (empty($row['exercise_id'])) {
            $this->showSuccessMessage('Fehler: Übung fehlt');
            return;
        }
        if (empty($row['playerCount'])) {
            $this->showSuccessMessage('Fehler: Spieleranzahl fehlt');
            return;
        }
        if (empty($row['time'])) {
            $this->showSuccessMessage('Fehler: Zeit fehlt');
            return;
        }

        try {
            $scheduleData = [
                'practice_id' => $this->practice->id,
                'exercise_id' => $row['exercise_id'],
                'playerCount' => $row['playerCount'],
                'goalkeeperCount' => $row['goalkeeperCount'] ?? 0,
                'time' => $row['time'],
                'coaches' => $row['coaches'] ?? '',
            ];

            if (!empty($row['id'])) {
                $schedule = Schedule::find($row['id']);
                if ($schedule) {
                    $schedule->update($scheduleData);
                    $this->showSuccessMessage('Aktualisiert!');
                } else {
                    $this->showSuccessMessage('Fehler: Eintrag nicht gefunden');
                }
            } else {
                $schedule = Schedule::create($scheduleData);
                $this->scheduleRows[$rowIndex]['id'] = $schedule->id;
                $this->showSuccessMessage('Neu gespeichert!');
            }
        } catch (\Exception $e) {
            $this->showSuccessMessage('Fehler beim Speichern: ' . $e->getMessage());
        }
    }

    public function toggleCollapse(): void
    {
        $this->isCollapsed = !$this->isCollapsed;
    }

    private function showSuccessMessage($message): void
    {
        $this->successMessage = $message;
        $this->dispatch('success-message');
    }

    public function render()
    {
        return view('livewire.practice-schedule-builder');
    }
}
