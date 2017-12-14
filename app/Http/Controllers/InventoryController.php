<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\InventoryItem;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Inventory $inventory, InventoryItem $inventory_item)
    {
        $inventories = $inventory->prepareForIndex($inventory->all());
        $newOrder = $inventory->orderBy('ordered','asc')->pluck('id')->toArray();

        $columns = $inventory_item->prepareTableColumns();
        $rows = $inventory_item->prepareTableRows($inventories);

        return view('inventories.index',compact(['inventories','columns','rows','newOrder']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Inventory $inventory)
    {
        $this->validate(request(), [
             'name' => 'required|string|max:255'
        ]);
        flash('Successfully created an Inventory!')->success();
        $last = $inventory->orderBy('id','desc')->first();
        $next = ($last) ? $last->ordered + 1 : 1;
        $request->request->add(['ordered' => $next]);
        $inventory->create($request->all());
        return redirect()->route('inventory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        return view('inventories.edit',compact(['inventory']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        $this->validate(request(), [
             'name' => 'required|string|max:255'
        ]);
        flash('Successfully updated an Inventory!')->success();
        $inventory->update($request->all());
        return redirect()->route('inventory.index');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {

        $inventory->inventoryItems()->delete();
        $delete = $inventory->delete();
        if ($delete) {
            flash('Successfully removed all inventories and inventory items associated.')->success();
            return redirect()->back();
        }
    }

    public function reorder(Request $request, Inventory $inventory) {
        collect($request->newOrder)->map(function ($value,$key) {
            $inventory = new Inventory();
            $inv = $inventory->find($value);
            $inv->update(['ordered'=>$key+1]);  
  
        });

        return response()->json([
            'status' => true,
            'message' => 'Successfully reordered inventory!'
        ]);
    }
}
