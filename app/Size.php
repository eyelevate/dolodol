<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
     use SoftDeletes;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'x_in',
        'y_in',
        'z_in',
        'x_cm',
        'y_cm',
        'z_cm',
        'inventory_item_id',
        'subtotal'
    ];

     #public
    public function prepareTableColumns()
    {
        $columns =  [
            [
                'label'=>'Size',
                'field'=> 'size',
                'filterable'=> true
            
            ], [
                'label'=>'Name',
                'field'=> 'name',
                'filterable'=> true
            ], [
                'label'=>'Created',
                'field'=> 'created_at',
                'type'=>'date',
                'inputFormat'=> 'YYYY-MM-DD HH:MM:SS',
                'outputFormat'=> 'MM/DD/YY hh:mm:ssa'
            ], [
                'label'=>'Action',
                'field'=> 'action',
                'html'=>true
            ]
        ];

        return json_encode($columns);
    }

    public function prepareTableIndexColumns()
    {
        $columns =  [
            [
                'label'=>'Size',
                'field'=> 'size',
                'filterable'=> true
            
            ], [
                'label'=>'Name',
                'field'=> 'name',
                'filterable'=> true
            ], [
                'label'=>'+ Price',
                'field'=> 'price',
                'filterable'=> true
            ]];

        return json_encode($columns);
    }

    public function prepareTableRows()
    {
        $rows = $this->all();
        $rows->transform(function($value, $key){
            $value['input_name'] = "stone_size[{$value->id}]";

            $value['action'] = '<button class="open-modal btn btn-secondary btn-sm" data-toggle="modal" data-target="#viewModal-'.$value->id.'" type="button">view</button>';

            return $value;
        });

        return $rows;
    }

    public function prepareData($rows)
    {
        // check if exists
        if (isset($rows)) {
            foreach ($rows as $key => $value) {
                //size input name
                $rows[$key]['input_name'] = "stone_size[{$value->id}]";
            }
        }
        return $rows;
    }

    public function prepareSizeForSelect($inventoryItem, $type)
    {
        switch ($type) {
            case 'cm':
                return $inventoryItem->sizeList->mapWithKeys(function($item) {
                    $name = strtoupper($item->name)." - ({$item->x_cm} length x {$item->y_cm} height x {$item->z_cm} width) +$".number_format($item->subtotal,2,'.',','); 
                    return [$item->id=>$name];
                });
                break;
            
            default:
                return $inventoryItem->sizeList->mapWithKeys(function($item) {
                    $name = strtoupper($item->name)." - ({$item->x_in} length x {$item->y_in} height x {$item->z_in} width) +$".number_format($item->subtotal,2,'.',','); 
                    return [$item->id=>$name];
                });
                break;
        }
        

        return false;
    }

    #Static
    public static function countSizes()
    {
        return Size::count();
    }
}
