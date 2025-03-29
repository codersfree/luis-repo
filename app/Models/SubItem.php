<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubItem extends Model
{
    protected $fillable = [
        'name', 'url', 'icon', 'order', 'item_id'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
