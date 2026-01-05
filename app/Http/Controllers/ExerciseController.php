<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    public function index(): Response
    {
        $exercises = Exercise::query()->with('categories')->get();
        $categories = Category::all();

        return response()->view('exercises/exercises', ['exercises' => $exercises, 'categories' => $categories]);
    }

    public function create(): Response
    {
        $categories = Category::all();

        return response()->view('exercises/create-exercises', ['categories' => $categories]);
    }

    public function store(Request $request): RedirectResponse
    {
        /** @var array{name: string, focus: string, material: ?string, duration: ?string, intensity: ?string, procedure: string, coaching: string, categories: array<int, int>} $validatedData */
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'focus' => 'required|string|max:255',
            'material' => 'nullable|string',
            'duration' => 'nullable|string',
            'intensity' => 'nullable|string',
            'procedure' => 'required|string',
            'coaching' => 'required|string',
            'drawing' => 'nullable|file',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        /** @var array<string, mixed> $exerciseData */
        $exerciseData = $request->except(['categories', 'drawing']);

        if ($request->hasFile('drawing')) {
            $file = $request->file('drawing');
            if ($file !== null) {
                $path = $file->store('exercises', 'public');
                $exerciseData['image'] = $path;
            }
        }

        /** @var User $user */
        $user = Auth::user();
        $exerciseData['user_id'] = $user->id;
        $exercise = Exercise::create($exerciseData);

        if (! empty($validatedData['categories'])) {
            $exercise->categories()->attach($validatedData['categories']);
        }

        return redirect()->route('exercises.index');
    }

    public function show(Exercise $exercise): Response
    {
        return response()->view('exercises/exercise-single', ['exercise' => $exercise]);
    }

    public function edit(Exercise $exercise): Response
    {
        $this->authorize('update', $exercise);

        $categories = Category::all();

        return response()->view('exercises/update-exercises', ['exercise' => $exercise, 'categories' => $categories]);
    }

    public function update(Request $request, Exercise $exercise): RedirectResponse
    {
        /** @var array{name: string, focus: string, material: ?string, duration: ?string, intensity: ?string, procedure: string, coaching: ?string, categories?: array<int, int>} $validatedData */
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'focus' => 'required|string|max:255',
            'material' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'intensity' => 'nullable|string|max:255',
            'procedure' => 'required|string',
            'coaching' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'drawing' => 'nullable|file|mimes:jpg,jpeg,png,gif',
        ]);

        $exercise->update(collect($validatedData)->except('categories')->toArray());

        if ($request->hasFile('drawing')) {
            $file = $request->file('drawing');
            if ($file !== null) {
                $path = $file->store('exercises', 'public');
                if ($path !== false) {
                    $exercise->image = $path;
                    $exercise->save();
                }
            }
        }

        if (isset($validatedData['categories'])) {
            $exercise->categories()->sync($validatedData['categories']);
        }

        return redirect()->route('exercises.show', $exercise->id)->with('success', 'Exercise updated successfully.');
    }
}
