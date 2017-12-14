<?php

namespace App;

use Carbon\Carbon;
use App\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contactus extends Model
{
    /**
     * stuatus definition
     * 1. new
     * 2. read
     * 3. archive
     *
     */

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function prepareTableColumns()
    {
        $columns =  [
            [
                'label'=>'Name',
                'field'=> 'name',
                'filterable'=> true
            ], [
                'label'=>'Email',
                'field'=> 'email',
                'filterable'=> true
            ], [
                'label'=>'Phone',
                'field'=> 'phone',
                'filterable'=> true
            ], [
                'label'=>'Subject',
                'field'=> 'subject',
                'filterable'=> true
            ], [
                'label'=>'Message',
                'field'=> 'message',
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

    public function prepareTableSelectColumns()
    {
        $columns =  [
            [ 'label'=>'Name',
                'field'=> 'name',
                'filterable'=> true
            ], [
                'label'=>'Email',
                'field'=> 'email',
                'filterable'=> true
            ], [
                'label'=>'Phone',
                'field'=> 'phone',
                'filterable'=> true
            ], [
                'label'=>'Subject',
                'field'=> 'subject',
                'filterable'=> true
            ], [
                'label'=>'Message',
                'field'=> 'message',
                'filterable'=> true
            ], [
                'label'=>'Action',
                'field'=> 'action',
                'html'=>true
            ]
        ];

        return json_encode($columns);
    }

    public function prepareSelect($data)
    {
        $select = [''=>'Subject'];
        if (isset($data)) {
            foreach ($data as $key => $value) {
                $select[$value->id] = $value->name;
            }
        }

        return $select;
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

    public static function prepareContactus()
    {
        $job = new Job();
        $statuses = [1=>1,2=>2,3=>3]; // check statuses above
        $contactus = [];
        // first section new and read only
        $first = Contactus::whereIn('status', [1,2])->orderBy('id', 'desc')->get();
        $second = Contactus::where('status', 3)->orderBy('id', 'desc')->get();
        $carbon = new Carbon();
        if (count($first) >0) {
            foreach ($first as $key => $value) {
                $first[$key]['created_at_formatted'] = $value->created_at->diffForHumans();
                $first[$key]['phone_formatted'] = $job->formatPhone($value->phone);
                $first[$key]['status_html'] = ($value->status == 1) ? 'callout-primary' :  'callout-muted';
                $contactus['first'][$value->created_at->diffInDays()][$key] = $value;
            }
        }

        $contactus['second'] = [];
        if (count($second) >0) {
            foreach ($second as $key => $value) {
                $second[$key]['created_at_formatted'] = $value->created_at->diffForHumans();
                $second[$key]['phone_formatted'] = $job->formatPhone($value->phone);
                $second[$key]['status_html'] = 'callout-muted';
                $contactus['second'][$value->created_at->diffInDays()][$key] = $value;
            }
        }
        return $contactus;
    }

    public static function countContactus()
    {
        return Contactus::where('status', 1)->count();
    }
}
