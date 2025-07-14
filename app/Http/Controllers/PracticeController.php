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
            ->name('practice-' . $practice->date->format('Y-m-d') . '.pdf');

        // Configure Chrome based on environment
        $pdf->withBrowsershot(function ($browsershot) {
            // Set timeout for all environments
            $browsershot->setOption('timeout', 60000); // 60 seconds
            
            if (app()->environment('local')) {
                // Local development - minimal configuration
                $browsershot->setOption('args', [
                    '--no-sandbox',
                    '--disable-dev-shm-usage',
                    '--disable-gpu',
                    '--headless',
                ]);

                // Let Puppeteer handle Chrome detection locally
                return $browsershot;
            } else {
                // Production server - simplified but effective configuration
                $browsershot->setOption('args', [
                    '--no-sandbox',
                    '--disable-setuid-sandbox',
                    '--disable-dev-shm-usage',
                    '--disable-gpu',
                    '--headless',
                    '--disable-web-security',
                    '--disable-features=VizDisplayCompositor',
                    '--disable-extensions',
                    '--disable-default-apps',
                    '--no-first-run',
                    '--disable-sync',
                    '--disable-translate',
                    '--metrics-recording-only',
                    '--enable-automation',
                    '--password-store=basic',
                    '--use-mock-keychain',
                    '--disable-touch-emulation',
                    '--disable-device-emulation',
                    '--disable-mobile-emulation',
                    '--disable-viewport-meta',
                    '--disable-background-timer-throttling',
                    '--disable-renderer-backgrounding',
                    '--disable-backgrounding-occluded-windows',
                    '--user-data-dir=/tmp/chrome-pdf-' . uniqid(),
                    '--virtual-time-budget=10000', // Limit execution time
                ]);

                // Disable viewport emulation to prevent the crash
                $browsershot->setOption('viewport', [
                    'width' => 1200,
                    'height' => 800,
                    'deviceScaleFactor' => 1,
                ]);

                // Production: Try direct Chrome first, then wrapper as fallback
                if (file_exists('/usr/bin/google-chrome-stable')) {
                    return $browsershot->setChromePath('/usr/bin/google-chrome-stable');
                } elseif (file_exists('/usr/local/bin/chrome-pdf')) {
                    return $browsershot->setChromePath('/usr/local/bin/chrome-pdf');
                }
            }

            return $browsershot;
        });

        return $pdf;
    }
}
