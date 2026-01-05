<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithFileUploads;

class CreateExercise extends Component
{
    use WithFileUploads;

    public ?string $name = null;

    public ?string $focus = null;

    /** @var array<int, int> */
    public array $categories = [];

    public ?string $material = null;

    public ?string $duration = null;

    public ?string $intensity = null;

    public ?int $playerCount = null;

    public ?int $goalkeeperCount = null;

    public mixed $level = null;

    public ?int $age = null;

    public ?string $procedure = null;

    public ?string $coaching = null;

    public TemporaryUploadedFile|string|null $image = null;

    /** @var Collection<int, Category>|null */
    public ?Collection $categoriesList = null;

    public function mount(): void
    {
        $this->categoriesList = Category::all();
    }

    public function render(): View
    {
        return view('livewire.create-exercise');
    }

    public function save(): RedirectResponse|Redirector
    {
        /** @var array<string, mixed> $validated */
        $validated = $this->validate();

        if ($this->image instanceof TemporaryUploadedFile) {
            $validated['image'] = $this->image->store('exercises', 'public');
        }

        /** @var User $user */
        $user = Auth::user();
        $validated['user_id'] = $user->id;

        $exercise = $user->exercises()->create($validated);

        if (! empty($this->categories)) {
            $exercise->categories()->sync($this->categories);
        }
        session()->flash('success', __('Exercise created successfully!'));

        return redirect()->route('exercises.index');
    }

    /**
     * @return array<string, string>
     */
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
