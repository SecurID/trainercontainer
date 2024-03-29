<?php

namespace App\Http\Controllers;

use App\Models\Practice;
use App\Models\Schedule;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Wnx\SidecarBrowsershot\BrowsershotLambda;
use function Spatie\LaravelPdf\Support\pdf;

class PracticeController extends Controller
{
    public function index()
    {
        $practices = Practice::where('user_id', Auth::user()->id)->get();

        return response()->view('practices/practices', ['practices' => $practices]);
    }

    public function create()
    {
        return response()->view('practices/create-practices');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'topic' => 'required|string',
            'rows.*.exerciseId' => 'required|integer',
            'rows.*.coaches' => 'required|string',
            'rows.*.time' => 'required|string',
            'rows.*.playerCount' => 'required|integer',
            'rows.*.goalkeeperCount' => 'required|integer',
        ]);

        $data = $request->all();

        $practice = new Practice();
        $date = DateTime::createFromFormat('d.m.Y', $data['date']);
        $practice->date = $date->format('Y-m-d');
        $practice->topic = $data['topic'];
        $practice->user_id = Auth::user()->id;
        $practice->save();

        foreach($data['rows'] as $row) {
            $schedule = new Schedule([
                'practice_id' => $practice->id,
                'exercise_id' => $row['exerciseId'],
                'coaches' => $row['coaches'],
                'time' => $row['time'],
                'playerCount' => $row['playerCount'],
                'goalkeeperCount' => $row['goalkeeperCount'],
            ]);
            $schedule->save();
        }

        return response()->json([
            'message' => 'Practice created successfully',
        ]);
    }


    public function show($id)
    {
        $practice = Practice::find($id);
        $schedule = Schedule::where('practice_id', $id)->get();
        return response()->view('practices/practice-single', ['practice' => $practice, 'schedules' => $schedule]);
    }


    public function destroy($id)
    {
        $practice = Practice::find($id);
        $schedule = Schedule::where('practice_id', $id)->get();
        foreach($schedule as $s) {
            $s->delete();
        }
        $practice->delete();
        return redirect()->route('practices.index')->with('success-message', 'Practice successfully deleted!');
    }

    public function print($id)
    {
        $practice = Practice::find($id);
        $schedule = Schedule::where('practice_id', $id)->get();
        return pdf()
            ->view('pdf/practice', ['practice' => $practice, 'schedules' => $schedule])
            ->format(Format::A4)
            ->landscape()
            ->onLambda()
            ->name('practice-'.$practice->date.'.pdf');
    }
}
