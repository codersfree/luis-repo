<?php

namespace App\Models;

use App\Observers\ItemObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ItemObserver::class)]
class Item extends Model
{
    protected $fillable = [
        'name', 'url', 'icon', 'order'
    ];

    public function subItems()
    {
        return $this->hasMany(SubItem::class);
    }
}
