<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rate',
        'status',
        'end'
    ];

    public function prepareTableColumns()
    {
        $columns =  [
            [
                'label'=>'ID',
                'field'=> 'id',
                'filterable'=> true
            ], [
                'label'=>'Rate',
                'field'=> 'rate',
                'filterable'=> true
            
            ], [
                'label'=>'Status',
                'field'=> 'status',
                'filterable'=> true
            ], [
                'label'=>'End',
                'field'=> 'end',
                'filterable'=> true
            ], [
                'label'=>'Created',
                'field'=> 'created_at',
                'type'=>'date',
                'inputFormat'=> 'YYYY-MM-DD HH:MM:SS',
                'outputFormat'=> 'MM/DD/YY hh:mm:ssa'
            ]];

        return json_encode($columns);
    }

    public function prepareTableRows($rows)
    {
        // check if exists
        if (isset($rows)) {
            foreach ($rows as $key => $value) {
                // append last column to table here
                $last_column = '<button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#viewModal-'.$value->id.'" type="button">view</button>';
                $last_column .= '</div>';
                $rows[$key]['action'] = $last_column;
            }
        }

        return $rows;
    }

    #Static
    public static function countSizes()
    {
        return Tax::count();
    }

}
