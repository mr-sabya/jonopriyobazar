<?php

namespace App\Livewire\Frontend\Home;

use App\Models\Banner as ModelsBanner;
use Livewire\Component;

class Banner extends Component
{
    public function render()
    {
        return view('livewire.frontend.home.banner',[
            'banners' => ModelsBanner::where('status', 1)->orderBy('id', 'ASC')->get(),
        ]);
    }
}
