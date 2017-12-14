<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'inventory_id',
        'inventory_item_id',
        'src',
        'type',
        'ordered'
    ];

    public function inventoryItems()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id', 'id');
    }
    
}
