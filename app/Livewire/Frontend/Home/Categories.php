<?php

namespace App\Livewire\Frontend\Home;

use App\Models\Category;
use Livewire\Component;

class Categories extends Component
{
    public function render()
    {
        return view('livewire.frontend.home.categories',[
            'categories' => Category::where('is_home', 1)->get(),
        ]);
    }
}
