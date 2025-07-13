<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::all();
        $categories = Category::all();
        return response()->view('exercises/exercises', ['exercises' => $exercises, 'categories' => $categories]);
    }

    public function create()
    {
        $categories = Category::all();
        return response()->view('exercises/create-exercises', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        // Validate request, especially for the new array of categories
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
            'categories.*' => 'exists:categories,id' // Validate each category ID exists
        ]);

        $exerciseData = $request->except(['categories', 'drawing']);

        if ($request->hasFile('drawing')) {
            $path = $request->file('drawing')->store('exercises', 'public');
            $exerciseData['image'] = $path;
        }

        $exerciseData['user_id'] = auth()->user()->id;
        $exercise = Exercise::create($exerciseData);

        if (!empty($validatedData['categories'])) {
            $exercise->categories()->attach($validatedData['categories']);
        }

        return redirect()->route('exercises.index');
    }


    public function show(Exercise $exercise)
    {
        return response()->view('exercises/exercise-single', ['exercise' => $exercise]);
    }

    public function edit(Exercise $exercise)
    {
        if ($exercise->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to edit this exercise.');
        }

        $categories = Category::all();
        return response()->view('exercises/update-exercises', ['exercise' => $exercise, 'categories' => $categories]);
    }

    public function update(Request $request, Exercise $exercise)
    {
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

        $exercise->update($validatedData);

        if ($request->hasFile('drawing')) {
            $path = $request->file('drawing')->store('exercises', 'public');
            $exercise->image = $path;
            $exercise->save();
        }

        if (isset($validatedData['categories'])) {
            $exercise->categories()->sync($validatedData['categories']);
        }

        return redirect()->route('exercises.show', $exercise->id)->with('success', 'Exercise updated successfully.');
    }
}
