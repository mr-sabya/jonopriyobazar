<?php

namespace App\Livewire\Frontend\Theme;

use Livewire\Component;
use App\Models\Category;

class CategoryWrap extends Component
{
    public function render()
    {
        // p_id 0 = Top level parents
        // sub.sub = Eager load children and grandchildren to prevent N+1 queries
        $menucategories = Category::with('sub.sub')
            ->where('p_id', 0)
            ->orderBy('name', 'ASC')
            ->get();

        return view('livewire.frontend.theme.category-wrap', [
            'menucategories' => $menucategories
        ]);
    }
}
