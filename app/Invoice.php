<?php

namespace App;

use App\Authorize;
use App\Job;
use App\User;
use App\Invoice;
use App\Tax;
use App\InventoryItem;
use App\Stone;
use App\Finger;
use App\Metal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    /**
    * Payment Types
    * 1 = Credit Card
    * 2 = Check
    * 3 = Cash
    **/

    /**
    * statuses
    * 1 = Created
    * 2 = Pending
    * 3 = Paid
    * 4 = Sent Delivery
    * 5 = Complete
    **/

    /**
    * shipping
    * 1 = Ground
    * 2 = 2 day air
    * 3 = next day
    * 4 = in-store pickup
    **/


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'employee_id',
        'vendor_id',
        'fob',
        'po_number',
        'requisitioner',
        'quantity',
        'subtotal',
        'tax',
        'total',
        'tendered',
        'payment_type',
        'last_four',
        'transaction_id',
        'street',
        'suite',
        'city',
        'state',
        'country',
        'zipcode',
        'comment',
        'terms',
        'status',
        'first_name',
        'last_name',
        'shipping',
        'shipping_total',
        'email_token'

    ];

    // Relations
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

    // Public methods
    public function prepareTableColumns()
    {
        $columns =  [
            [
                'label'=>'ID',
                'field'=> 'id_padded',
                'filterable'=> true
            ], [
                'label'=>'Name',
                'field'=> 'full_name',
                'filterable'=> true
            
            ], [
                'label'=>'Quantity',
                'field'=> 'quantity',
                'filterable'=> true
            ], [
                'label'=>'Subtotal',
                'field'=> 'subtotal_formatted',
                'filterable'=> true
            ], [
                'label'=>'Tax',
                'field'=> 'tax_formatted',
                'filterable'=> true
            ], [
                'label'=>'Shipping',
                'field'=> 'shipping_formatted',
                'filterable'=> true
            ], [
                'label'=>'Total',
                'field'=> 'total_formatted',
                'filterable'=> true
            ], [
                'label'=>'Status',
                'field'=> 'status_html',
                'html'=> true
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
            ]];

        return json_encode($columns);
    }

    public function prepareTableRows()
    {
        $job = new Job();
        $details = $this->orderBy('id','desc')->get();

        if (count($details) > 0) {
            foreach ($details as $key => $value) {
                $details[$key]['id_padded'] = str_pad($value->id, 6, '0',STR_PAD_LEFT);

                // first name
                $details[$key]['first_name'] = (isset($value->users)) ? ucFirst($value->users->first_name) : ucFirst($value->first_name);

                // last Name
                $details[$key]['last_name'] = (isset($value->users)) ? ucFirst($value->users->last_name) : ucFirst($value->last_name);

                // full name
                $details[$key]['full_name'] = ucFirst($value->last_name).', '.ucFirst($value->first_name);
                if (isset($value->users)) {
                    $details[$key]['full_name'] = ucFirst($value->users->last_name).', '.ucFirst($value->users->first_name);
                }

                // Shipping Address
                $street = (isset($value->users)) ? $value->users->street : $value->street;
                $suite = (isset($value->users)) ? $value->users->suite : $value->suite;
                $full_street = (isset($suite)) ? $street.' '.$suite : $street;
                $city = (isset($value->users)) ? $value->users->city : $value->city;
                $state = (isset($value->users)) ? $value->users->state : $value->state;
                $country = (isset($value->users)) ? $value->users->country : $value->country;
                $zipcode = (isset($value->users)) ? $value->users->zipcode : $value->zipcode;

                $shipping_address = $full_street." <br/> ".ucFirst($city).", ".ucFirst($state)." ".$zipcode;

                $details[$key]['shipping_address'] = $shipping_address;


                // Phone
                $phone = (isset($value->users)) ? $value->users->phone : $value->phone;
                $details[$key]['phone'] = $job->formatPhone($phone);


                // Email
                $email = (isset($value->users)) ? $value->users->email : $value->email;
                $details[$key]['email'] = $email;

                // Shipping Type
                $details[$key]['shipping_type'] = $this->getShippingType($value->shipping);

                // Payment Type
                $details[$key]['payment_type'] = $this->getPaymentType($value->payment_type);

                // totals
                $details[$key]['subtotal_formatted'] = number_format($value->subtotal,2,'.',',');
                $details[$key]['tax_formatted'] = number_format($value->tax,2,'.',',');
                $details[$key]['shipping_formatted'] = number_format($value->shipping_total,2,'.',',');
                $details[$key]['total_formatted'] = number_format($value->total,2,'.',',');

                // status_html
                if (isset($value->status)) {
                    switch ($value->status) {
                        case 1:
                            $details[$key]['status_html'] = '<span class="badge">Created By Admin</span>';
                            break;
                        case 2:
                            $details[$key]['status_html'] = '<span class="badge badge-warning">Pending</span>';
                            break;
                        case 3:
                            $details[$key]['status_html'] = '<span class="badge badge-success">Paid</span>';
                            break;
                        default:
                            $details[$key]['status_html'] = '<span class="badge badge-default">Complete</span>';
                            break;
                    }
                }

                // append last column to table here
                $last_column = '<button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#viewModal-'.$value->id.'" type="button">view</button>';
                $last_column .= '</div>';
                $details[$key]['action'] = $last_column;

                if (count($value->invoiceItems) > 0) {
                    foreach ($value->invoiceItems as $item) {
                        // dd($item);
                    }
                }
            }
        }

        return $details;

    }



    public static function countInvoices()
    {
        return Invoice::where('status','<',5)->count();
    }
}
