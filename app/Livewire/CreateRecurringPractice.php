<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateRecurringPractice extends Component
{
    public ?string $start_date = null;

    public ?string $end_date = null;

    /** @var array<int, string> */
    public array $weekdays = [];

    public ?string $time = null;

    public bool $success = false;

    /** @var array<string, string> */
    protected array $rules = [
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'weekdays' => 'required|array|min:1',
        'time' => 'required',
    ];

    public function create(): void
    {
        $this->validate();

        if ($this->start_date === null || $this->end_date === null) {
            return;
        }

        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        /** @var array<int, Carbon> $dates */
        $dates = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if (in_array($date->format('N'), $this->weekdays)) {
                $dates[] = $date->copy();
            }
        }

        /** @var User $user */
        $user = Auth::user();
        foreach ($dates as $date) {
            $user->practices()->create([
                'date' => $date->format('Y-m-d'),
                'time' => $this->time,
                'topic' => __('messages.training'),
            ]);
        }
        $this->success = true;
        $this->reset(['start_date', 'end_date', 'weekdays', 'time']);
        $this->redirectRoute('practices.index');
    }

    public function render(): View
    {
        return view('livewire.create-recurring-practice');
    }
}
