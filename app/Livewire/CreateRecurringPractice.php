<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class CreateRecurringPractice extends Component
{
    public $start_date;
    public $end_date;
    public $weekdays = [];
    public $time;
    public $success = false;

    protected $rules = [
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'weekdays' => 'required|array|min:1',
        'time' => 'required',
    ];

    public function create()
    {
        $this->validate();
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        $dates = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if (in_array($date->format('N'), $this->weekdays)) {
                $dates[] = $date->copy();
            }
        }
        foreach ($dates as $date) {
            Auth::user()->practices()->create([
                'date' => $date->format('Y-m-d'),
                'time' => $this->time,
                'topic' => 'Training',
            ]);
        }
        $this->success = true;
        $this->reset(['start_date', 'end_date', 'weekdays', 'time']);
        $this->redirectRoute('practices.index');
    }

    public function render()
    {
        return view('livewire.create-recurring-practice');
    }
}

