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
        // Try wkhtmltopdf first if available (more reliable for servers)
        if ($this->isWkhtmltopdfAvailable()) {
            return $this->generatePdfWithWkhtmltopdf($practice);
        }

        // Fallback to Browsershot/Chrome
        return $this->generatePdfWithBrowsershot($practice);
    }

    private function isWkhtmltopdfAvailable(): bool
    {
        $wkhtmltopdfPaths = [
            '/usr/bin/wkhtmltopdf',
            '/usr/local/bin/wkhtmltopdf',
            config('app.wkhtmltopdf_path'),
        ];

        foreach ($wkhtmltopdfPaths as $path) {
            if ($path && file_exists($path)) {
                return true;
            }
        }

        return false;
    }

    private function generatePdfWithWkhtmltopdf(Practice $practice)
    {
        // Generate HTML content
        $html = view('pdf/practice', [
            'practice' => $practice, 
            'schedules' => $practice->schedules()->get()
        ])->render();

        // Save HTML to temporary file
        $tempHtmlFile = tempnam(sys_get_temp_dir(), 'practice_') . '.html';
        file_put_contents($tempHtmlFile, $html);

        // Generate PDF with wkhtmltopdf
        $tempPdfFile = tempnam(sys_get_temp_dir(), 'practice_') . '.pdf';
        $wkhtmltopdfPath = $this->getWkhtmltopdfPath();
        
        $command = sprintf(
            '%s --page-size A4 --orientation Landscape --margin-top 10mm --margin-right 10mm --margin-bottom 10mm --margin-left 10mm "%s" "%s"',
            $wkhtmltopdfPath,
            $tempHtmlFile,
            $tempPdfFile
        );

        exec($command, $output, $returnCode);

        // Clean up HTML file
        unlink($tempHtmlFile);

        if ($returnCode !== 0 || !file_exists($tempPdfFile)) {
            throw new \Exception('Failed to generate PDF with wkhtmltopdf');
        }

        // Return PDF response
        $fileName = 'practice-' . $practice->date->format('Y-m-d') . '.pdf';
        
        return response()->file($tempPdfFile, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ])->deleteFileAfterSend(true);
    }

    private function getWkhtmltopdfPath(): string
    {
        $paths = [
            config('app.wkhtmltopdf_path'),
            '/usr/bin/wkhtmltopdf',
            '/usr/local/bin/wkhtmltopdf',
        ];

        foreach ($paths as $path) {
            if ($path && file_exists($path)) {
                return $path;
            }
        }

        return '/usr/bin/wkhtmltopdf'; // Default fallback
    }

    private function generatePdfWithBrowsershot(Practice $practice)
    {
        $pdf = Pdf::view('pdf/practice', ['practice' => $practice, 'schedules' => $practice->schedules()->get()])
            ->format(Format::A4)
            ->landscape()
            ->name('practice-' . $practice->date->format('Y-m-d') . '.pdf');

        // Configure Chrome/Chromium with minimal arguments for compatibility
        $pdf->withBrowsershot(function ($browsershot) {
            $browsershot->setOption('args', [
                '--no-sandbox',
                '--disable-dev-shm-usage',
                '--disable-gpu',
                '--headless',
                '--disable-crash-reporter',
                '--disable-extensions',
                '--no-first-run',
                '--disable-default-apps',
                '--single-process',
            ]);

            // Try to find a working Chrome installation
            $chromePaths = [
                '/usr/bin/google-chrome-stable',
                '/usr/bin/google-chrome',
                '/usr/bin/chromium-browser',
                '/usr/bin/chromium',
            ];

            foreach ($chromePaths as $path) {
                if (file_exists($path)) {
                    return $browsershot->setChromePath($path);
                }
            }

            return $browsershot;
        });

        return $pdf;
    }
}
