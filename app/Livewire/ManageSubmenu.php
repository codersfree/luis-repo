<?php

namespace App\Livewire;

use Livewire\Component;

class ManageSubmenu extends Component
{

    public $item;
    public $subItems;

    public function render()
    {
        return view('livewire.manage-submenu');
    }
}
