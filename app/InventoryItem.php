<?php

namespace App;

use App\StoneSize;
use App\Stone;
use App\Finger;
use App\Metal;
use App\Job;
use App\ItemMetal;
use App\ItemStone;
use App\ItemSize;
use App\Tax;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
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
        'inventory_id',
        'sizes',
        'subtotal',
        'taxable',
        'active',
        'featured'
    ];

    /** 
    * PUBLIC METHODS
    */
    public function inventories()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'inventory_item_id', 'id');
    }

    public function sizeList()
    {
        return $this->hasMany(Size::class, 'inventory_item_id', 'id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'inventory_item_id', 'id');
    }

    public function collectionItem()
    {

        return $this->belongsToMany(Collection::class,'collection_item','inventory_item_id','collection_id');
    }

    #public

    public function getSubtotal($data,$quantity = 1, $size_id = null)
    {
        $email = false;
        $subtotal = 0;
        if (isset($data)) {
            $subtotal = $data->subtotal;

            if(isset($size_id)) {
                $stoneSize = $data->sizeList()->find($size_id);

                $subtotal += $stoneSize->subtotal;
            }

        }
        $subtotal *= $quantity;

        return $subtotal;
    }

    public function getSubtotalAdmin($data,$quantity = 1,$metal_id = null,$stone_id= null, $stone_size_id = null, $custom_price = null)
    {
        $email = false;
        $subtotal = 0;
        if (isset($data)) {
            $subtotal = $data->subtotal;
            if(isset($stone_id)) {
                $stone = $data->itemStone()->find($stone_id);
                if ($stone) {
                    if($stone->stones->email) {
                        $email = true;
                        $subtotal += $custom_price;
                    } else {
                        $subtotal += $stone->price;
                    }
                    
                }
                $stoneSize = $data->itemSize()->where('stone_size_id',$stone_size_id)->first();
                // $stoneSize = StoneSize::find($stone_size_id);
                if(!$email) {
                    $subtotal += $stoneSize->price;
                } 
                   
            }
            
            if(isset($metal_id)) {

                $metal = $data->itemMetal()->find($metal_id);
                if ($metal) {
                    $subtotal += $metal->price;
                }

            }

        }
        $subtotal *= $quantity;

        return $subtotal;
    }


    public function prepareCart($data)
    {
        // dd($data);

        if(isset($data)){
            foreach ($data as $key => $value) {
                // get ring size

                $data[$key]['ring_size'] = NULL;
                if ($value['inventoryItem']['fingers']) {
                    $ring_size = Finger::find($value['finger_id']);
                    $data[$key]['ring_size'] = $ring_size->name;
                } 
                
                
                $get_subtotal = $this->getSubtotal($value['inventoryItem'],$value['quantity'], $value['size_id']);
                $data[$key]['subtotal'] = $get_subtotal;

                // set primary image
                $primary_img = '';
                if(isset($value['inventoryItem']['images'])) {
                    foreach ($value['inventoryItem']['images'] as $ikey => $ivalue) {
                        
                        if ($ivalue->primary) {
                            $primary_img = str_replace('public/','storage/',$ivalue->img_src);
                            break;
                        }
                    }
                }
                $data[$key]['img_src'] = $primary_img;

            }

        }
        return $data;
    }
    public function prepareCartAdmin($data)
    {
        // dd($data);
        $cart = [];
        if(isset($data)){
            if (isset($data->invoiceItems)) {
                foreach ($data->invoiceItems as $key => $item) {
                    $cart[$key]['inventoryItem'] = $item->inventoryItem;
                    $cart[$key]['shipping'] = $data->shipping;
                    $cart[$key]['quantity'] = $item->quantity;
                    $cart[$key]['subtotal'] = $item->subtotal;
                    $cart[$key]['finger_id'] = $item->finger_id;
                    $cart[$key]['metal_id'] = $item->item_metal_id;
                    $cart[$key]['stone_id'] = $item->item_stone_id;
                    $cart[$key]['stone_size_id'] = $item->item_size_id;
                    $cart[$key]['email'] = $item->itemStone->stones->email;

                    $cart[$key]['ring_size'] = NULL;
                    if (isset($item->inventoryItem->fingers)) {
                        $ring_size = Finger::find($item->finger_id);
                        if (isset($ring_size)) {
                            $cart[$key]['ring_size'] = $ring_size->name;
                        }

                    } 

                    // get stone type
                    $cart[$key]['stone_type'] = NULL;
                    if(isset($item->inventoryItem->stones)) {
                        $stone_type = ItemStone::find($item->item_stone_id);
                        
                        if (isset($stone_type)) {
                            $cart[$key]['stone_type'] = $stone_type->stones->name;
                        }
                    }
                    
                    // get stone size
                    $cart[$key]['size_name'] = NULL;
                    if (isset($item->inventoryItem->sizes)) {
                        $stone_size = ItemSize::find($item->item_size_id);
                        if (isset($stone_size)) {
                            $cart[$key]['size_name'] = $stone_size->stoneSizes->sizes->name;
                        }
                    }
                    
                    
                    // get metal type
                    $cart[$key]['metal_name'] = NULL;
                    if (isset($item->inventoryItem->metals)) {
                        $metal_type = ItemMetal::find($item->item_metal_id);
                        if (isset($metal_type)) {
                            $cart[$key]['metal_name'] = $metal_type->metals->name;
                        }
                    }

                    // set primary image
                    $primary_img = '';
                    if(isset($item->inventoryItem->images)) {
                        foreach ($item->inventoryItem->images as $ikey => $ivalue) {
                            
                            if ($ivalue->primary) {
                                $primary_img = str_replace('public/','storage/',$ivalue->img_src);
                                break;
                            }
                        }
                    }
                    $cart[$key]['img_src'] = $primary_img;
                }
            }
            
        }

        return $cart;
    }

    public function prepareTotals($data)
    {
        $totals = [
            'quantity'=>0,
            'subtotal'=>0,
            '_subtotal'=>0,
            'tax'=>0,
            '_tax'=>0,
            'shipping'=>0,
            '_shipping'=>0,
            'total'=>0,
            '_total'=>0,
        ];
        $quantity = 0;
        $sub_total = 0;
        $tax = 0;
        $total = 0;
        $shipping = 0;
        $taxes = new Tax();
        $tax_rate = $taxes->where('status',1)->first();
        if(isset($data)){
            foreach ($data as $key => $value) {
                $shipping_id = (isset($value['shipping'])) ? $value['shipping'] : 1;
                $shipping = $this->shippingRates($shipping_id);
                $get_subtotal = $this->getSubtotal($value['inventoryItem'],$value['quantity'], $value['size_id']);            
                $totals['_subtotal'] += $get_subtotal + $shipping;


                // calculate totals
                $totals['quantity'] += $value['quantity'];

            }

            $total = round($totals['_subtotal'] * (1+$tax_rate->rate),2);
            $tax = $total - $totals['_subtotal'];
            $final_total = $total + $shipping;

            $totals['subtotal'] = '$'.number_format($totals['_subtotal'],2,'.',',');
            $totals['total'] = '$'.number_format($final_total,2,'.',',');
            $totals['_total'] = $final_total;
            $totals['tax'] = '$'.number_format($tax,2,'.',',');
            $totals['_tax'] =   $tax ;
            $totals['shipping'] = '$'.number_format($shipping,2,'.',',');;
            $totals['_shipping'] = 0;

        }

        return $totals;        
    }

    public function prepareTotalsFinish($data)
    {
        $totals = [
            'quantity'=>0,
            'subtotal'=>0,
            '_subtotal'=>0,
            'tax'=>0,
            '_tax'=>0,
            'shipping'=>0,
            '_shipping'=>0,
            'total'=>0,
            '_total'=>0,
        ];
        $quantity = 0;
        $sub_total = 0;
        $tax = 0;
        $total = 0;
        $shipping = 0;
        $taxes = new Tax();
        $tax_rate = $taxes->where('status',1)->first();
        if(isset($data)){
            foreach ($data as $key => $value) {
                $shipping_id = (isset($value['shipping'])) ? $value['shipping'] : 1;
                $shipping = $this->shippingRates($shipping_id);
                $totals['quantity'] += $value['quantity'];
                $get_subtotal = ($shipping) ? $value['subtotal'] : 0;
                if ($shipping) {
                    $totals['_subtotal'] += $get_subtotal;
                }
            }

            $total = ($shipping) ? round($totals['_subtotal'] * (1+$tax_rate->rate),2) : 0;
            $tax = ($shipping) ?  $total - $totals['_subtotal'] :  0;
            $final_total = ($shipping) ?  $total + $shipping: 0;

            $totals['subtotal'] = ($shipping) ? '$'.number_format($totals['_subtotal'],2,'.',',') : 'Priced Later';
            $totals['total'] = ($shipping) ?  '$'.number_format($final_total,2,'.',',') : 'Priced Later';
            $totals['_total'] = ($shipping) ?  $final_total : null;
            $totals['tax'] = ($shipping) ? '$'.number_format($tax,2,'.',',') : 'Priced Later';
            $totals['_tax'] =  ($shipping) ? $tax :  null;
            $totals['shipping'] = ($shipping) ? '$0.00' : 'Priced Later';
            $totals['_shipping'] = $shipping;


        }

        return $totals;        
    }

    public function prepareTotalsFinishEdit($data, $shippingTotal)
    {
        $totals = [
            'quantity'=>0,
            'subtotal'=>0,
            '_subtotal'=>0,
            'tax'=>0,
            '_tax'=>0,
            'shipping'=>0,
            '_shipping'=>0,
            'total'=>0,
            '_total'=>0,
        ];
        $quantity = 0;
        $sub_total = 0;
        $tax = 0;
        $total = 0;
        $shipping = 0;
        $taxes = new Tax();
        $tax_rate = $taxes->where('status',1)->first();
        if(isset($data)){
            foreach ($data as $key => $value) {
                $shipping_id = $value['shipping'];
                $shipping = $this->shippingRates($shipping_id);
                $totals['quantity'] += $value['quantity'];
                $get_subtotal = $value['subtotal'];
                $totals['_subtotal'] += $get_subtotal;
   
            }

            $total = round($totals['_subtotal'] * (1+$tax_rate->rate),2);
            $tax = $total - $totals['_subtotal'];
            $final_total = $total + $shippingTotal;

            $totals['subtotal'] = '$'.number_format($totals['_subtotal'],2,'.',',');
            $totals['total'] = '$'.number_format($final_total,2,'.',',');
            $totals['_total'] = $final_total;
            $totals['tax'] = '$'.number_format($tax,2,'.',',');
            $totals['_tax'] =  $tax;
            $totals['shipping'] = '$'.number_format($shippingTotal,2,'.',',');
            $totals['_shipping'] = $shippingTotal;


        }

        return $totals;        
    }


    public function prepareTotalsAdmin($data)
    {
        $totals = [
            'quantity'=>$data->quantity,
            'subtotal'=>'$'.number_format($data->subtotal,2,'.',','),
            '_subtotal'=>$data->subtotal,
            'tax'=>'$'.number_format($data->tax,2,'.',','),
            '_tax'=>$data->tax,
            'shipping'=>'$'.number_format($data->shipping_total,2,'.',','),
            '_shipping'=>$data->shipping_total,
            'total'=>'$'.number_format($data->total,2,'.',','),
            '_total'=>$data->total,
        ];
        

        return $totals;        
    }

    public function prepareDataSingle($data)
    {   
        $job = new Job();

        if (isset($data)) {

            if ($data->images) {


                $primary_img = $data->images()->where('primary',true)->first();
                $primary_src = ($primary_img) ? $primary_img->img_src : null;
                
                $non_primary_imgs = $data->images()->where('primary',false)->orderBy('ordered','asc')->get();
                $data['primary_src'] = asset(str_replace('public/','storage/',$primary_src));
                $data['non_primary_imgs'] = $non_primary_imgs;

            }

            if($data->videos) {
                foreach ($data->videos as $key => $value) {
                    $data['videos'][$key]['name'] = 'ovideos['.$value->id.']';
                    $data['videos'][$key]['src_name'] = $job->stringToDotDotDot($value->src); 
                    $data['videos'][$key]['src_formatted'] = asset(str_replace('public/', 'storage/', $value->src));
                }
            }

            if($data->sizeList) {
                
            }
        }
        return $data;
    }   

    public function prepareForFrontend($data)
    {
        // check if exists
    
        if (isset($data)) {
            foreach ($data as $key => $value) {
                if ($value->images) {
                    $first = $value->images()->where('primary',true)->first();
                    $last = $value->images()->where('primary',false)->orderBy('ordered','asc')->get();
                    $data[$key]['primary_img_src'] = asset(str_replace('public/', 'storage/', $first->featured_src));
                    // dd($data[$key]['primary_img_src']);

                }
                
            }
        }



        return $data;
    }

    public function prepareForShowInventory($data)
    {

        $job = new Job();
        if (isset($data)) {
            foreach ($data as $ikey => $ivalue) {
                //name 
                $data[$ikey]['name_short'] = $job->stringToDotDotDot($ivalue->name);
                $data[$ikey]['desc_short'] = $job->stringToDotDotDot($ivalue->desc);
    



                // collection item
                $data[$ikey]['collection_set'] = false;
                if (count($ivalue->collectionItem) > 0) {
                    foreach ($ivalue->collectionItem as $collection) {
                        $pivot_collection_id = $collection->pivot->collection_id;
                        if ($pivot_collection_id == $collection->id) {
                            $data[$ikey]['collection_set'] = true;
                            break;
                        }
                    }
                    
                }
                $data[$ikey]['collectionItem'] = (count($ivalue->collectionItem) > 0) ? $ivalue->collectionItem : [];
                if (count($ivalue->images) > 0) {
                    foreach ($ivalue->images as $iikey => $iivalue) {

                        $primary_img = $ivalue->images()->where('primary',true)->first();
                        $primary_src = ($primary_img) ? $primary_img->img_src : null;
                        
                        $non_primary_imgs = $ivalue->images()->where('primary',false)->orderBy('ordered','asc')->get();
                        $data[$ikey]['primary_src'] = asset(str_replace('public/','storage/',$primary_src));
                        $data[$ikey]['non_primary_imgs'] = $non_primary_imgs;

                    }
                }
                
            }
        }
        return $data;
    }

    public function prepareForShowCollection($data)
    {
        if (isset($data)) {
            foreach ($data as $ikey => $ivalue) {
                if (count($ivalue->images) > 0) {
                    foreach ($ivalue->images as $iikey => $iivalue) {

                        $primary_img = $ivalue->images()->where('primary',true)->first();
                        $primary_src = ($primary_img) ? $primary_img->img_src : null;
                        
                        $non_primary_imgs = $ivalue->images()->where('primary',false)->orderBy('ordered','asc')->get();
                        $data[$ikey]['primary_src'] = asset(str_replace('public/','storage/',$primary_src));
                        $data[$ikey]['non_primary_imgs'] = $non_primary_imgs;

                    }
                }
                
            }
        }
        return $data;
    }


    public function prepareTableColumns()
    {
        $columns =  [
            [
                'label'=>'Name',
                'field'=> 'name',
                'filterable'=> true
            
            ], [
                'label'=>'Description',
                'field'=> 'desc',
                'filterable'=> true
            ], [
                'label'=>'Subtotal',
                'field'=> 'subtotal',
                'filterable'=> true
            
            ], [
                'label'=>'Taxable',
                'field'=> 'taxable_status',
                'filterable'=> true
            ], [
                'label'=>'Active',
                'field'=> 'active_status',
                'html'=> true
            ], [
                'label'=>'Featured',
                'field'=> 'featured_status',
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
            ]];

        return json_encode($columns);
    }

    public function prepareTableRows($inventories)
    {
        // check if exists
        if (isset($inventories)) {
            foreach ($inventories as $key => $value) {
                if(count($value->inventoryItems) > 0){
                    foreach ($value->inventoryItems as $iikey => $iivalue) {
                        // append last column to table here
                        $last_column = '<button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#viewModal-'.$iivalue->id.'" type="button">view</button>';
                        $last_column .= '</div>';
                        $inventories[$key]['inventoryItems'][$iikey]['action'] = $last_column;


                        // active
                        if (isset($inventories[$key]['inventoryItems'][$iikey]['active'])) {
                            $inventories[$key]['inventoryItems'][$iikey]['active_status'] = ($iivalue->active) ? '<span class="badge badge-success">Active</span>' :  '<span class="badge badge-danger">In-active</span>';
                        }  

                        // Collection Name
                        if (isset($inventories[$key]['inventoryItems'][$iikey]['collection_id'])) {
                            $inventories[$key]['inventoryItems'][$iikey]['collection_name'] = ($iivalue->collections) ? $iivalue->collections->name :  'None';
                        } 

                        // taxable
                        if (isset($inventories[$key]['inventoryItems'][$iikey]['taxable'])) {
                            $inventories[$key]['inventoryItems'][$iikey]['taxable_status'] = ($iivalue->taxable) ? 'Yes' :  'No';
                        } 

                        // metals
                        if (isset($inventories[$key]['inventoryItems'][$iikey]['metals'])) {
                            $inventories[$key]['inventoryItems'][$iikey]['metals_status'] = ($iivalue->metals) ? 'Yes' :  'No';
                        } 

                        // Stone 
                        if (isset($inventories[$key]['inventoryItems'][$iikey]['stones'])) {
                            $inventories[$key]['inventoryItems'][$iikey]['stones_status'] = ($iivalue->stones) ? 'Yes' :  'No';
                        } 

                        // Fingers
                        if (isset($inventories[$key]['inventoryItems'][$iikey]['fingers'])) {
                            $inventories[$key]['inventoryItems'][$iikey]['fingers_status'] = ($iivalue->fingers) ? 'Yes' :  'No';
                        } 

                        // Featured
                        if (isset($inventories[$key]['inventoryItems'][$iikey]['featured'])) {
                            $inventories[$key]['inventoryItems'][$iikey]['featured_status'] = ($iivalue->featured) ? 'Yes' :  'No';
                        } 

                        // images
                        if (isset($inventories[$key]['inventoryItems'][$iikey]['images'])) {
                            $first = $iivalue->images()->where('primary',true)->first();
                            $last = $iivalue->images()->where('primary',false)->orderBy('ordered','asc')->get();
                            $ordered = $iivalue->images()->orderBy('ordered','asc')->get();
                            $inventories[$key]['inventoryItems'][$iikey]['primary_image'] = $first;
                            $inventories[$key]['inventoryItems'][$iikey]['non_primary_images'] = $last;
                            
                        } 
                    }
                }
                
            }
        }

        return $inventories;
    }




    public static function countInventoryItems()
    {
        return InventoryItem::count();
    }

    /**
    * Private Functions
    **/
    private function shippingRates($shipping)
    {
        $rate = 0;

        switch ($shipping) {
            case 1: 
                return 0;
                break;
            default:
                return 0;
                break;
        }
    }

}
