<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\Setting;
use Livewire\Component;

class Header extends Component
{
    public function render()
    {
        return view('livewire.frontend.theme.header',[
            'setting' => Setting::find(1),
        ]);
    }
}
