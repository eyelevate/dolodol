<?php

namespace App\Http\Controllers;

use App\Finger;
use App\ItemMetal;
use App\ItemStone;
use App\ItemSize;
use App\Stone;
use App\Invoice;
use App\InvoiceItem;
use App\InventoryItem;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceItem $invoiceItem, InventoryItem $inventoryItem, Finger $finger, ItemMetal $itemMetal, ItemStone $itemStone, ItemSize $itemSize, Stone $stone)
    {
        $fingers = $finger->prepareSelect($finger->all());
        $metals = $itemMetal->prepareSelect($invoiceItem->inventoryItem->itemMetal);
        $stones = $stone->all();

        $stone_select = $itemStone->prepareSelect($invoiceItem->inventoryItem->itemStone);
        $stone_sizes = $itemSize->prepareSelect($invoiceItem->inventoryItem);
        // dd($stone_sizes);

        return view('invoice_items.edit',compact(['invoiceItem','fingers','metals','stones','stone_select','stone_sizes']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceItem $invoiceItem, Invoice $invoice)
    {
        $this->validate(request(), [
            'quantity' => 'required|numeric',
            'subtotal'=>'required'
        ]);
        
        $request->merge(['item_size_id'=>$request->item_size_id[$request->item_stone_id]]);
        if ($invoiceItem->update($request->all())) {
            // check to see if email if so then update status and update invoice totals
            $email = $invoiceItem->itemStone->stones->email;
            $update_totals = $invoice->updateTotalsFromId($invoiceItem->invoice_id);
            if ($update_totals) {
                flash('Successfully updated invoice item and its totals!')->success();
                return redirect()->route('admin.index');
            }
            
        }
        flash('Error processing your save. Please try again')->warning();
        return redirect()->back();



        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceItem $invoiceItem)
    {
        //
    }

    public function updatePrice(Request $request, InvoiceItem $invoiceItem)
    {

    }
}
