<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $exerciseData = $request->except('categories');
        if ($request->hasFile('drawing')) {
            $path = Storage::putFile('exercises', $request->file('drawing'));
            $exerciseData['image'] = Storage::url($path);
        }

        $exerciseData['user_id'] = auth()->user()->id;
        $exercise = Exercise::create($exerciseData);

        if (!empty($validatedData['categories'])) {
            $exercise->categories()->attach($validatedData['categories']);
        }

        return redirect()->route('exercises.index');
    }


    public function show($id)
    {
        $exercise = Exercise::find($id);
        return response()->view('exercises/exercise-single', ['exercise' => $exercise]);
    }

    public function edit($id)
    {
        $exercise = Exercise::find($id);
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
            $path = Storage::putFile('exercises', $request->file('drawing'));
            $exercise->drawing = Storage::url($path);
            $exercise->save();
        }

        if (isset($validatedData['categories'])) {
            $exercise->categories()->sync($validatedData['categories']);
        }

        return redirect()->route('exercises.show', $exercise->id)->with('success', 'Exercise updated successfully.');
    }
}
