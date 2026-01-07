<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\Setting;
use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        return view('livewire.frontend.theme.footer',[
            'setting' => Setting::find(1),
        ]);
    }
}
