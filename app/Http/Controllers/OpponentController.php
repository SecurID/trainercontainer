<?php

namespace App\Http\Controllers;

use App\Models\Opponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opponents = Opponent::where('user_id', Auth::user()->id)
            ->orderBy('name')
            ->get();

        return response()->view('opponents/opponents', ['opponents' => $opponents]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('opponents/create-opponent');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $opponent = new Opponent([
            'name' => $data['name'],
            'notes' => $data['notes'],
            'user_id' => Auth::user()->id,
        ]);
        $opponent->save();

        return redirect()->route('opponents.index')->with('success-message', 'Opponent created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Opponent $opponent)
    {
        $this->authorize('view', $opponent);

        $games = $opponent->games()->orderBy('date', 'desc')->get();

        return response()->view('opponents/opponent-single', [
            'opponent' => $opponent,
            'games' => $games,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Opponent $opponent)
    {
        $this->authorize('update', $opponent);

        return response()->view('opponents/edit-opponent', ['opponent' => $opponent]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Opponent $opponent)
    {
        $this->authorize('update', $opponent);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $opponent->update($data);

        return redirect()->route('opponents.index')->with('success-message', 'Opponent updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opponent $opponent)
    {
        $this->authorize('delete', $opponent);

        $opponent->delete();

        return redirect()->route('opponents.index')->with('success-message', 'Opponent successfully deleted!');
    }
}
