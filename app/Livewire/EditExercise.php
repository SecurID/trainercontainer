<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Exercise;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Database\Eloquent\Collection;

class EditExercise extends Component
{
    use WithFileUploads;

    public Exercise $exercise;

    public ?string $name = null;

    public ?string $focus = null;

    public array $categories = [];

    public ?string $material = null;

    public ?string $duration = null;

    public ?string $intensity = null;

    public ?int $playerCount = null;

    public ?int $goalkeeperCount = null;

    public $level = null;

    public ?int $age = null;

    public ?string $procedure = null;

    public ?string $coaching = null;

    public $image = null;

    public ?Collection $categoriesList = null;

    public function mount(Exercise $exercise): void
    {
        if ($exercise->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to edit this exercise.');
        }

        $this->exercise = $exercise;
        $this->categoriesList = Category::all();
        
        $this->name = $exercise->name;
        $this->focus = $exercise->focus;
        $this->material = $exercise->material;
        $this->duration = $exercise->duration;
        $this->intensity = $exercise->intensity;
        $this->playerCount = $exercise->playerCount;
        $this->goalkeeperCount = $exercise->goalkeeperCount;
        $this->level = $exercise->level;
        $this->age = $exercise->age;
        $this->procedure = $exercise->procedure;
        $this->coaching = $exercise->coaching;
        $this->categories = $exercise->categories->pluck('id')->toArray();
    }

    public function render()
    {
        return view('livewire.edit-exercise');
    }

    public function update()
    {
        $validated = $this->validate();

        if ($this->image) {
            $validated['image'] = $this->image->store('exercises', 'public');
        } else {
            unset($validated['image']);
        }

        $this->exercise->update($validated);

        $this->exercise->categories()->sync($this->categories);

        session()->flash('success', __('Exercise updated successfully!'));
        return redirect()->route('exercises.index');
    }

    public function delete()
    {
        if ($this->exercise->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to delete this exercise.');
        }

        $this->exercise->delete();

        session()->flash('success', __('Exercise deleted successfully!'));
        return redirect()->route('exercises.index');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'focus' => 'nullable|string',
            'material' => 'nullable|string',
            'duration' => 'nullable|string',
            'intensity' => 'nullable|string',
            'playerCount' => 'nullable|integer',
            'goalkeeperCount' => 'nullable|integer',
            'level' => 'nullable',
            'age' => 'nullable|integer',
            'procedure' => 'nullable|string',
            'coaching' => 'nullable|string',
            'image' => 'nullable|file|image|max:2048',
        ];
    }
}