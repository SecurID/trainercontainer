<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Exercise;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ExercisesFilter extends Component
{
    public string|int $selectedCategoryId = 'all';

    public function render(): View
    {
        $categories = Category::all();

        if ($this->selectedCategoryId === 'all') {
            $exercises = Exercise::query()->with('categories')->get();
        } else {
            $exercises = Exercise::query()->whereHas('categories', function ($query): void {
                $query->where('categories.id', $this->selectedCategoryId);
            })->get();
        }

        return view('livewire.exercises-filter', compact('exercises', 'categories'));
    }

    public function filterByCategory(string|int $categoryId): void
    {
        $this->selectedCategoryId = $categoryId;
    }
}
