<?php

namespace App\Livewire\Frontend\Category;

use App\Models\Category;
use Livewire\Component;

class Index extends Component
{
    public $currentCategory;

    public function mount($currentCategory = null)
    {
        $this->currentCategory = $currentCategory;
    }

    public function render()
    {
        // Determine the parent ID (0 for root, or the ID of the current category)
        $parentId = $this->currentCategory ? $this->currentCategory->id : 0;

        // Fetch categories and count their subcategories in one query
        $categories = Category::where('p_id', $parentId)
            ->withCount('subcategories') // Assumes relationship name is 'subcategories'
            ->get();

        return view('livewire.frontend.category.index', [
            'categories' => $categories
        ]);
    }
}
