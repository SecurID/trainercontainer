<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Exercise;
use App\Models\Category;

class ExercisesFilter extends Component
{
    public $selectedCategoryId = 'all';

    public function render()
    {
        $categories = Category::all();

        if ($this->selectedCategoryId == 'all') {
            $exercises = Exercise::with('categories')->get();
        } else {
            $exercises = Exercise::whereHas('categories', function ($query) {
                $query->where('categories.id', $this->selectedCategoryId);
            })->get();
        }

        return view('livewire.exercises-filter', compact('exercises', 'categories'));
    }

    public function filterByCategory($categoryId): void
    {
        $this->selectedCategoryId = $categoryId;
    }
}
