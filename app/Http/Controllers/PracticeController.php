<?php

namespace App\Http\Controllers;

use App\Models\Practice;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Facades\Pdf;

class PracticeController extends Controller
{
    public function index()
    {
        $practices = Practice::where('user_id', Auth::user()->id)
            ->where('date', '>=', now())
            ->orderBy('date')
            ->get();

        return response()->view('practices/practices', ['practices' => $practices]);
    }

    public function create()
    {
        return response()->view('practices/create-practices');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'topic' => 'required|string',
            'rows.*.exerciseId' => 'required|integer',
            'rows.*.coaches' => 'required|string',
            'rows.*.time' => 'required|string',
            'rows.*.playerCount' => 'required|integer',
            'rows.*.goalkeeperCount' => 'required|integer',
        ]);

        $practice = new Practice([
            'date' => DateTime::createFromFormat('d.m.Y', $data['date']),
            'topic' => $data['topic'],
            'user_id' => Auth::user()->id,
        ]);
        $practice->save();

        foreach($data['rows'] as $row) {
            $practice->schedules()->create([
                'exercise_id' => $row['exerciseId'],
                'coaches' => $row['coaches'],
                'time' => $row['time'],
                'playerCount' => $row['playerCount'],
                'goalkeeperCount' => $row['goalkeeperCount'],
            ]);
        }

        return response()->json([
            'message' => 'Practice created successfully',
        ]);
    }


    public function show(Practice $practice)
    {
        $players = Auth::user()->players()->get()->sortBy('lastname');
        return response()->view('practices/practice-single', [
            'practice' => $practice,
            'schedules' => $practice->schedules()->get(),
            'players' => $players,
        ]);
    }

    public function schedule(Practice $practice)
    {
        return view('practices.practice-schedule', [
            'practice' => $practice,
            'schedules' => $practice->schedules()->get(),
        ]);
    }


    public function destroy(Practice $practice)
    {
        $practice->schedules()->delete();
        $practice->delete();
        return redirect()->route('practices.index')->with('success-message', 'Practice successfully deleted!');
    }

    public function print(Practice $practice)
    {
        $pdf = Pdf::view('pdf/practice', ['practice' => $practice, 'schedules' => $practice->schedules()->get()])
            ->format(Format::A4)
            ->landscape()
            ->name('practice-'.$practice->date.'.pdf');

        // Configure Chrome/Chromium path for different environments
        $pdf->withBrowsershot(function ($browsershot) {
            // Use environment variable if set
            if ($chromePath = config('app.chrome_path')) {
                if (file_exists($chromePath)) {
                    return $browsershot->setChromePath($chromePath);
                }
            }

            // Try common Chrome/Chromium paths
            $chromePaths = [
                '/usr/bin/chromium-browser',      // Your production server
                '/usr/bin/google-chrome-stable',  // Common production path
                '/usr/bin/google-chrome',         // Alternative production path
                '/usr/bin/chromium',              // Alternative chromium path
                '/opt/google/chrome/chrome',      // Another common path
            ];

            foreach ($chromePaths as $path) {
                if (file_exists($path)) {
                    return $browsershot->setChromePath($path);
                }
            }

            // Try Puppeteer's Chrome (updated for version 23)
            $puppeteerChromePaths = [
                '/var/www/.cache/puppeteer/chrome/linux-131.0.6778.204/chrome-linux64/chrome', // Puppeteer 23
                '/var/www/.cache/puppeteer/chrome/linux-127.0.6533.88/chrome-linux64/chrome',  // Fallback
            ];
            
            foreach ($puppeteerChromePaths as $chromePath) {
                if (file_exists($chromePath)) {
                    return $browsershot->setChromePath($chromePath);
                }
            }

            // For local development, let Puppeteer handle Chrome detection
            return $browsershot;
        });

        return $pdf;
    }
}
