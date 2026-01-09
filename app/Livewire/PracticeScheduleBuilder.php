<?php

namespace App\Livewire;

use App\Models\Exercise;
use App\Models\Practice;
use App\Models\Schedule;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class PracticeScheduleBuilder extends Component
{
    public Practice $practice;

    /** @var array<int, array<string, mixed>> */
    public array $scheduleRows = [];

    /** @var array<int, string> */
    public array $exerciseSearchTerms = [];

    /** @var Collection<int, Exercise> */
    public Collection $exercises;

    /** @var array<string, string> */
    protected array $rules = [
        'scheduleRows.*.exercise_id' => 'required|exists:exercises,id',
        'scheduleRows.*.playerCount' => 'required|integer|min:1|max:30',
        'scheduleRows.*.goalkeeperCount' => 'nullable|integer|min:0|max:5',
        'scheduleRows.*.time' => 'required|string|max:20',
        'scheduleRows.*.coaches' => 'nullable|string|max:100',
    ];

    public function mount(Practice $practice): void
    {
        $this->practice = $practice;
        $this->exercises = Exercise::query()->orderBy('name')->get();
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
                'exercise_id' => (string) $schedule->exercise_id,
                'playerCount' => $schedule->playerCount,
                'goalkeeperCount' => $schedule->goalkeeperCount,
                'time' => $schedule->time,
                'coaches' => $schedule->coaches,
            ];
            $this->exerciseSearchTerms[$index] = $schedule->exercise?->name ?? '';
        }
    }

    public function addRow(): void
    {
        $newIndex = count($this->scheduleRows);
        $this->scheduleRows[$newIndex] = [
            'id' => null,
            'exercise_id' => '',
            'playerCount' => null,
            'goalkeeperCount' => 0,
            'time' => '',
            'coaches' => '',
        ];
        $this->exerciseSearchTerms[$newIndex] = '';
    }

    public function removeRow(int $index): void
    {
        if (isset($this->scheduleRows[$index]['id'])) {
            $schedule = Schedule::query()->find($this->scheduleRows[$index]['id']);
            if ($schedule instanceof Schedule) {
                $schedule->delete();
            }
        }

        unset($this->scheduleRows[$index]);
        unset($this->exerciseSearchTerms[$index]);
        $this->scheduleRows = array_values($this->scheduleRows);
        $this->exerciseSearchTerms = array_values($this->exerciseSearchTerms);

        $this->showSuccessMessage(__('messages.entry_removed'));
    }

    public function selectExercise(int $rowIndex, int $exerciseId): void
    {
        $exercise = Exercise::query()->find($exerciseId);

        if (! $exercise instanceof Exercise) {
            return;
        }

        $this->scheduleRows[$rowIndex]['exercise_id'] = (string) $exerciseId;
        $this->exerciseSearchTerms[$rowIndex] = $exercise->name;

        // Auto-fill exercise defaults if fields are empty
        if ($exercise->playerCount && ! $this->scheduleRows[$rowIndex]['playerCount']) {
            $this->scheduleRows[$rowIndex]['playerCount'] = $exercise->playerCount;
        }
        if ($exercise->goalkeeperCount !== null && ! $this->scheduleRows[$rowIndex]['goalkeeperCount']) {
            $this->scheduleRows[$rowIndex]['goalkeeperCount'] = $exercise->goalkeeperCount;
        }
        if ($exercise->duration !== null && ! $this->scheduleRows[$rowIndex]['time']) {
            $this->scheduleRows[$rowIndex]['time'] = $exercise->duration;
        }

        $this->saveScheduleRow($rowIndex);
    }

    public function updatedScheduleRowsExerciseId(string $value, string $key): void
    {
        $rowIndex = (int) $key;
        $exerciseId = (int) $value;

        if ($exerciseId <= 0) {
            return;
        }

        $exercise = Exercise::query()->find($exerciseId);

        if (! $exercise instanceof Exercise) {
            return;
        }

        // Auto-fill exercise defaults if fields are empty
        if ($exercise->playerCount && ! $this->scheduleRows[$rowIndex]['playerCount']) {
            $this->scheduleRows[$rowIndex]['playerCount'] = $exercise->playerCount;
        }
        if ($exercise->goalkeeperCount !== null && ! $this->scheduleRows[$rowIndex]['goalkeeperCount']) {
            $this->scheduleRows[$rowIndex]['goalkeeperCount'] = $exercise->goalkeeperCount;
        }
        if ($exercise->duration !== null && ! $this->scheduleRows[$rowIndex]['time']) {
            $this->scheduleRows[$rowIndex]['time'] = $exercise->duration;
        }

        $this->saveScheduleRow($rowIndex);
    }

    public function updatedScheduleRows(mixed $value, string $key): void
    {
        if (str_contains($key, '.')) {
            [$rowIndex, $field] = explode('.', $key);

            if ($field !== 'exercise_name') {
                $this->saveScheduleRow((int) $rowIndex);
            }
        }
    }

    public function saveScheduleRow(int $rowIndex): void
    {
        if (! isset($this->scheduleRows[$rowIndex])) {
            $this->showSuccessMessage(__('messages.error_row_not_found'));

            return;
        }

        $row = $this->scheduleRows[$rowIndex];

        // Check required fields
        if (empty($row['exercise_id'])) {
            $this->showSuccessMessage(__('messages.error_exercise_missing'));

            return;
        }
        if (empty($row['playerCount'])) {
            $this->showSuccessMessage(__('messages.error_player_count_missing'));

            return;
        }
        if (empty($row['time'])) {
            $this->showSuccessMessage(__('messages.error_time_missing'));

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

            if (! empty($row['id'])) {
                $schedule = Schedule::query()->find($row['id']);
                if ($schedule instanceof Schedule) {
                    $schedule->update($scheduleData);
                    $this->showSuccessMessage(__('messages.updated'));
                } else {
                    $this->showSuccessMessage(__('messages.error_entry_not_found'));
                }
            } else {
                $schedule = Schedule::create($scheduleData);
                $this->scheduleRows[$rowIndex]['id'] = $schedule->id;
                $this->showSuccessMessage(__('messages.new_saved'));
            }
        } catch (\Exception $e) {
            $this->showSuccessMessage(__('messages.error_saving', ['message' => $e->getMessage()]));
        }
    }

    private function showSuccessMessage(string $message): void
    {
        Flux::toast($message);
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

    public function render(): View
    {
        return view('livewire.practice-schedule-builder');
    }
}
