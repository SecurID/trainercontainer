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

        return response()->view('exercises/create-exercises');
    }

    public function store(Request $request)
    {
        $exercise = new Exercise();
        $exercise->name = $request->name;
        $exercise->focus = $request->focus;
        $exercise->save();

        return redirect()->route('exercises.index');
    }

    public function show($id)
    {
        $exercise = Exercise::find($id);
        return response()->view('exercises/exercise-single', ['exercise' => $exercise]);
    }

    public function edit($id)
    {
        //
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
