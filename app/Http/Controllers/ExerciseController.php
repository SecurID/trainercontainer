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
        return response()->view('exercises/exercise-single', ['exercise' => $exercise]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function getExerciseAutocomplete(Request $request)
    {
        if($request->has('term')){
            $data = Exercise::where('name', 'like', '%'.$request->input('term').'%')->limit(4)->get();
            return response()->json($data);
        }
    }
}
