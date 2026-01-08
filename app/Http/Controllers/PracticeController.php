<?php

namespace App\Http\Controllers;

use App\Models\Practice;
use App\Models\User;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class PracticeController extends Controller
{
    public function index(): Response
    {
        /** @var User $user */
        $user = Auth::user();
        $today = now()->startOfDay();

        $upcomingPractices = Practice::query()
            ->where('user_id', $user->id)
            ->where('date', '>=', $today)
            ->orderBy('date')
            ->get();

        $pastPractices = Practice::query()
            ->where('user_id', $user->id)
            ->where('date', '<', $today)
            ->orderBy('date', 'desc')
            ->get();

        return response()->view('practices/practices', [
            'upcomingPractices' => $upcomingPractices,
            'pastPractices' => $pastPractices,
        ]);
    }

    public function create(): Response
    {
        return response()->view('practices/create-practices');
    }

    public function store(Request $request): JsonResponse
    {
        /** @var array{date: string, topic: string, rows: array<int, array{exerciseId: int, coaches: string, time: string, playerCount: int, goalkeeperCount: int}>} $data */
        $data = $request->validate([
            'date' => 'required|date',
            'topic' => 'required|string',
            'rows.*.exerciseId' => 'required|integer',
            'rows.*.coaches' => 'required|string',
            'rows.*.time' => 'required|string',
            'rows.*.playerCount' => 'required|integer',
            'rows.*.goalkeeperCount' => 'required|integer',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $practice = new Practice([
            'date' => DateTime::createFromFormat('d.m.Y', $data['date']),
            'topic' => $data['topic'],
            'user_id' => $user->id,
        ]);
        $practice->save();

        foreach ($data['rows'] as $row) {
            $practice->schedules()->create([
                'exercise_id' => $row['exerciseId'],
                'coaches' => $row['coaches'],
                'time' => $row['time'],
                'playerCount' => $row['playerCount'],
                'goalkeeperCount' => $row['goalkeeperCount'],
            ]);
        }

        return response()->json([
            'message' => __('messages.practice_created'),
        ]);
    }

    public function show(Practice $practice): Response
    {
        $this->authorize('view', $practice);

        /** @var User $user */
        $user = Auth::user();
        $players = $user->players()->orderBy('lastname')->get();

        return response()->view('practices/practice-single', [
            'practice' => $practice,
            'schedules' => $practice->schedules()->get(),
            'players' => $players,
        ]);
    }

    public function schedule(Practice $practice): View
    {
        $this->authorize('view', $practice);

        return view('practices.practice-schedule', [
            'practice' => $practice,
            'schedules' => $practice->schedules()->get(),
        ]);
    }

    public function destroy(Practice $practice): RedirectResponse
    {
        $this->authorize('delete', $practice);

        $practice->schedules()->delete();
        $practice->delete();

        return redirect()->route('practices.index')->with('success-message', __('messages.practice_deleted'));
    }

    public function print(Practice $practice): PdfBuilder
    {
        $this->authorize('view', $practice);

        /** @var \Carbon\Carbon $date */
        $date = $practice->date;

        return Pdf::view('pdf/practice', ['practice' => $practice, 'schedules' => $practice->schedules()->get()])
            ->format(Format::A4)
            ->landscape()
            ->name('practice-'.$date->format('Y-m-d').'.pdf')
            ->onLambda();
    }
}
