<?php

namespace App;

use App\InventoryItem;
use App\Job;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'desc',
        'ordered'
    ];

    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class, 'inventory_id', 'id');
    }

    
    public function prepareSelect()
    {
        $select = [''=>'select inventory group'];
        $inventories =  $this->orderBy('name', 'asc')->get();
        if (count($inventories) > 0) {
            foreach ($inventories as $inventory) {
                $select[$inventory->id] = $inventory->name;
            }
        }
        return $select;
    }

    public function prepareForIndex()
    {
        $collection = collect($this->orderBy('name', 'asc')->get())->map(function ($value,$key) {
            $value['count_items'] = count($value->inventoryItems);
            $value['active_state'] = ($value->ordered == 1) ? true : false;
            return $value;
        })->sortBy('ordered')->values();
        return $collection;
    }

    public function prepareForSet($collection_id)
    {
        $job = new Job();
        $itms = new InventoryItem();
        $inventories =  $this->orderBy('name', 'asc')->get();
        $inventories->transform(function($value, $key) use ($itms,$job, $collection_id){
            $value['desc'] = $job->stringToDotDotDot($value->desc, 40);

            $value->inventoryItems->transform(function($ivalue, $ikey) use ($collection_id, $job) {
                $ivalue['collection_set'] = $ivalue->collectionItem()->where('collection_id',$collection_id)->exists();
                $ivalue['desc'] = $job->stringToDotDotDot($ivalue->desc);
                $primary_img = $ivalue->images()->where('primary',true)->first();
                $ivalue['primary_src'] =asset(str_replace('public/', 'storage/', $primary_img->img_src));

                $non_primary_imgs = $ivalue->images()->where('primary',false)->orderBy('ordered', 'asc')->get();
                $ivalue['non_primary_imgs'] = $non_primary_imgs;

                return $ivalue;
            });

            return $value;
        });

        return $inventories;
    }

    public function reorder($ordered, $id)
    {
        $ordered++;
        if($this->find($id)->update(['ordered'=>$ordered])) {
            return true;
        }

        return false;

    }


    public static function countInventories()
    {
        return Inventory::count();
    }
}
