<?php

namespace App;

use App\InventoryItem;
use App\InvoiceItem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'inventory_item_id',
        'item_metal_id',
        'item_stone_id',
        'item_size_id',
        'custom_stone_price',
        'serial',
        'finger_id',
        'quantity',
        'subtotal'
    ];

    // relations
    public function invoices()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id', 'id');
    }
    public function itemMetal()
    {
        return $this->belongsTo(ItemMetal::class, 'item_metal_id', 'id');
    }
    public function itemStone()
    {
        return $this->belongsTo(ItemStone::class, 'item_stone_id', 'id');
    }
    public function itemSize()
    {
        return $this->belongsTo(ItemSize::class, 'item_size_id', 'id');
    }
    public function fingers()
    {
        return $this->belongsTo(Finger::class, 'finger_id', 'id');
    }

    // methods

    public function makeTopTen($take = 20)
    {


        $invoiceItems = $this->groupBy('inventory_item_id')
            ->select('inventory_item_id',\DB::raw('sum(quantity) as total'))
            ->orderBy('total','desc')
            ->take($take)
            ->get();

        
        if (count($invoiceItems) > 0) {
            foreach ($invoiceItems as $key => $value) {
                $sum = 0;
                $grab = $this->where('inventory_item_id',$value->inventory_item_id)->get();
                if (count($grab) > 0) {
                    foreach ($grab as $g) {
                        $sum += $g->quantity;

                    }
                }
                $invoiceItems[$key]['total'] = $sum;
                if(isset($value->inventoryItem)){
                    if(isset($value->inventoryItem->images)) {
                        foreach ($value->inventoryItem->images as $imkey => $image) {

                            if($image->primary) {
                                $invoiceItems[$key]['inventoryItem']['img_src'] = asset(str_replace('public/','storage/',$image->img_src));
                            }
                        }
                    }
                } else {
                    $trashed = $value->inventoryItem()->withTrashed()->first();
                    $inventoryItems[$key]['inventoryItem']= $trashed;
                    if (isset($trashed)) {
                        $imgs = $trashed->images;
                        if(isset($imgs)) {
                            
                            foreach ($imgs as $imkey => $image) {

                                if($image->primary) {
                                    $invoiceItems[$key]['inventoryItem'][$tkey]['img_src'] = asset(str_replace('public/','storage/',$image->img_src));
                                }
                            }
                        }
                    }

                }
                
            }
        }
        return $invoiceItems;
    }

    public function newInvoiceItems($invoice, $cart)
    {
        $inventoryItem = new InventoryItem();
        $cart_count = count($cart);
        if (count($cart) > 0) {
            foreach ($cart as $item) {
                $email = $item['email'];
                $ii = $item['inventoryItem'];
                $invItemObject = $inventoryItem->find($ii['id']);
                $quantity = $item['quantity'];
                $item_size_id = (!$email) ? ($ii['sizes']) ? $item['stone_size_id'] : NULL : NULL;
                $item_metal_id = ($ii['metals']) ? $item['metal_id'] : NULL;
                $item_stone_id = ($ii['stones']) ? $item['stone_id'] : NULL;
                $item_finger_id = ($ii['fingers']) ? $item['finger_id'] : NULL;
                $subtotal = (!$email) ? $inventoryItem->getSubtotal($invItemObject,$quantity,$item_metal_id,$item_stone_id, $item_size_id) : NULL;

                $invoice_item = new InvoiceItem();
                $invoice_item->invoice_id = $invoice->id;
                $invoice_item->inventory_item_id = $invItemObject->id;
                $invoice_item->quantity = $quantity;
                $invoice_item->subtotal = ($subtotal) ? $subtotal : 0;
                $invoice_item->item_metal_id = $item_metal_id;
                $invoice_item->item_stone_id = $item_stone_id;
                $invoice_item->finger_id = $item_finger_id;
                $invoice_item->item_size_id = $item_size_id;
                if ($invoice_item->save()) {
                    $cart_count--;
                }

                
            }
        }
        return ($cart_count == 0) ? true : false;
    }

    public function updateInvoiceItems($cart)
    {
        
        $inventoryItem = new InventoryItem();
        $cart_count = count($cart['selectedOptions']);
        if (count($cart['selectedOptions']) > 0) {
            foreach ($cart['selectedOptions'] as $item) {
                $ii = $item['inventoryItem'];

                $quantity = $item['quantity'];
                $item_size_id = ($item['stone_size_id']) ? $item['stone_size_id'] : NULL;
                $item_metal_id = ($item['metal_id']) ? $item['metal_id'] : NULL;
                $item_stone_id = ($item['stone_id']) ? $item['stone_id'] : NULL;
                $item_finger_id = ($item['finger_id']) ? $item['finger_id'] : NULL;
                $subtotal = $item['subtotal'];

                $invoiceItem = InvoiceItem::find($item['id']);
                $invoiceItem->inventory_item_id = $ii['id'];
                $invoiceItem->quantity = $quantity;
                $invoiceItem->subtotal = ($subtotal) ? $subtotal : 0;
                $invoiceItem->item_metal_id = $item_metal_id;
                $invoiceItem->item_stone_id = $item_stone_id;
                $invoiceItem->finger_id = $item_finger_id;
                $invoiceItem->item_size_id = $item_size_id;
                if ($invoiceItem->save()) {
                    $cart_count--;
                }

                
            }
        }
        return ($cart_count == 0) ? true : false;
    }
}
