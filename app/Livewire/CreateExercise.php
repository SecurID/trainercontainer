<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Database\Eloquent\Collection;

class CreateExercise extends Component
{
    use WithFileUploads;

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

    public function mount(): void
    {
        $this->categoriesList = Category::all();
    }

    public function render()
    {
        return view('livewire.create-exercise');
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->image) {
            $validated['image'] = $this->image->store('exercises', 'public');
        }

        $validated['user_id'] = auth()->user()->id;

        $exercise = Auth::user()->exercises()->create($validated);

        if (!empty($this->categories)) {
            $exercise->categories()->sync($this->categories);
        }
        session()->flash('success', __('Exercise created successfully!'));
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
