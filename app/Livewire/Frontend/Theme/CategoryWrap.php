<?php

namespace App\Livewire\Frontend\Theme;

use Livewire\Component;
use App\Models\Category;

class CategoryWrap extends Component
{
    public function render()
    {
        // Eager loading 'sub.sub' prevents multiple database hits inside the loops
        $menucategories = Category::with('sub.sub')
            ->where('p_id', 0)
            ->get();

        return view('livewire.frontend.theme.category-wrap', [
            'menucategories' => $menucategories
        ]);
    }
}