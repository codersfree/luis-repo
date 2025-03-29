<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Attributes\On;
use Livewire\Component;

class Navigation extends Component
{
    public $items;

    public function mount()
    {
        $this->getItems();
    }

    #[On('menuUpdated')]
    public function getItems()
    {
        $this->items = Item::with('subItems')
            ->orderBy('order')
            ->get();
    }

    public function render()
    {
        return view('livewire.navigation');
    }
}
