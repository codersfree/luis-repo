<?php

namespace App\Observers;

use App\Models\Item;

class ItemObserver
{
    public function creating(Item $item)
    {
        $item->order = Item::max('order') + 1;
    }
}
