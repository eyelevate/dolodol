<?php

namespace App;

use App\User;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'role_id',
        'street',
        'suite',
        'city',
        'state',
        'country',
        'zipcode',
        'password'
    ];


    // Relationships
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function prepareTableColumns()
    {
        $columns =  [
            [
                'label'=>'ID',
                'field'=> 'id',
                'filterable'=> true
            ], [
                'label'=>'First',
                'field'=> 'first_name',
                'filterable'=> true
            ], [
                'label'=>'Last',
                'field'=> 'last_name',
                'filterable'=> true
            ], [
                'label'=>'Phone',
                'field'=> 'phone',
                'filterable'=> true
            ], [
                'label'=>'Email',
                'field'=> 'email',
                'filterable'=> true
            ], [
                'label'=>'Created',
                'field'=> 'created_at',
                'type'=>'date',
                'inputFormat'=> 'YYYY-MM-DD HH:MM:SS',
                'outputFormat'=> 'MM/DD/YY hh:mm:ssa'
            ], [
                'label'=>'Updated',
                'field'=> 'updated_at',
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
            [
                'label'=>'First',
                'field'=> 'first_name',
                'filterable'=> true
            ], [
                'label'=>'Last',
                'field'=> 'last_name',
                'filterable'=> true
            ], [
                'label'=>'Phone',
                'field'=> 'phone',
                'filterable'=> true
            ], [
                'label'=>'Email',
                'field'=> 'email',
                'filterable'=> true
            ], [
                'label'=>'Action',
                'field'=> 'action',
                'html'=>true
            ]
        ];

        return json_encode($columns);
    }

    public function prepareTableRows($rows, $role = 1)
    {
        

        // check if exists
        if (isset($rows)) {
            foreach ($rows as $key => $value) {
                // append last column to table here
                $last_column = '<a class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#viewModal-'.$value->id.'" href="#">View</a>';
                $last_column .= '</div>';
                $rows[$key]['action'] = $last_column;
            }
        }

        return $rows;
    }

    public function prepareTableSelectRows($rows)
    {
        

        // check if exists
        if (isset($rows)) {
            foreach ($rows as $key => $value) {
                // append last column to table here
                $last_column = '<button type="button" class="select-employee btn btn-success btn-sm" employee-id="'.$value->id.'" employee-first-name="'.$value->first_name.'" employee-last-name="'.$value->last_name.'" employee-email="'.$value->email.'">Select</button>';
                $last_column .= '</div>';
                $rows[$key]['action'] = $last_column;
            }
        }

        return $rows;
    }

    public function prepareTableSelectClientRows($rows)
    {
        

        // check if exists
        if (isset($rows)) {
            foreach ($rows as $key => $value) {
                $full_name = ucFirst($value->last_name).', '.ucFirst($value->first_name).' ('.$value->email.')';
                // append last column to table here
                $last_column = '<button type="button" class="client-selected btn btn-success btn-sm" client-id="'.$value->id.'" client-name="'.$full_name.'">Select</button>';
                $last_column .= '</div>';
                $rows[$key]['action'] = $last_column;
            }
        }

        return $rows;
    }

    public function prepareTableSelectDeployRows($rows)
    {
        

        // check if exists
        if (isset($rows)) {
            foreach ($rows as $key => $value) {
                // append last column to table here
                $last_column = '<button type="button" class="select-customer btn btn-info btn-sm" customer-id="'.$value->id.'">Find Company</button>';
                $last_column .= '</div>';
                $rows[$key]['action'] = $last_column;
            }
        }

        return $rows;
    }

    public static function countEmployees($role_id = 4)
    {

        return User::where('role_id','<', $role_id)->count();
    }

    public static function countCustomers($role_id = 4)
    {
         
        return User::where('role_id', $role_id)->count();
    }

    public function getOnlineByRole($data, $role_id)
    {
        if (isset($data)) {
            foreach ($data as $key => $value) {
                if ($role_id != $value->role_id) {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }
}
