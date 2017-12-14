<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Job;
use App\Image;
use App\Inventory;
use App\InventoryItem;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    private $layout;
    private $view;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Job $job)
    {
        $theme = 2;
        $this->layout = $job->switchLayout($theme);
        $this->view = $job->switchHomeView($theme);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Collection $collection)
    {
        $columns = $collection->prepareTableColumns();
        $rows = $collection->prepareTableRows($collection->all());
        return view('collections.index', compact(['columns','rows']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('collections.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Collection $collection, Image $image)
    {
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'img' => [
                'required',
                'mimes:jpeg,jpg,png',
                'max:10000',
                // Rule::dimesions()->ratio(1)
            ]
        ]);
        

        // store the newly created and resized image into the storage folder with a unique token as a name and return the path for db storage
        $resized_image_uri = $image->crop($request->img,1250, 1250);
        $path = Storage::putFile('public/collections', new File($resized_image_uri));
        

        //Now delete temporary intervention image as we have moved it to Storage folder with Laravel filesystem.
        unlink($resized_image_uri);

        // check if featured is set to true if true then create a resize of the image to 1902x1070
        if ($request->featured == 'on') {
            $resized_featured_uri = $image->resize($request->img, 2500, 1250);
            $featured_path = Storage::putFile('public/collections', new File($resized_image_uri));
            unlink($resized_featured_uri);
            $request->merge(['featured_src'=>$featured_path]);
        }


        // save the path of the image
        $request->merge(['img_src'=>$path]);
        
        // merge the switch on/off to true or false
        $request->merge(['active'=>($request->active == 'on') ? true : false]);
        $request->merge(['featured'=>($request->featured == 'on') ? true : false]);
        
        // update flash with success
        flash('Successfully created a Collection!')->success();
        
        // creat the db row and return user back to index page
        $collection->create($request->all());
        return redirect()->route('collection.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        $layout = $this->layout;
        $collections = $collection->prepareForShow($collection);
        return view('collections.show', compact('layout', 'collections'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Collection  $Collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        return view('collections.edit', compact('collection'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CollectionController  $collectionController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collection $collection, Image $image)
    {
        //Validate the form
        $this->validate(request(), [
             'name' => 'required|string|max:255',
             'img'=>'mimes:jpeg,jpg,png | max:10000'
        ]);
        $request->merge(['active'=>($request->active == 'on') ? true : false]);
        $request->merge(['featured'=>($request->featured == 'on') ? true : false]);

        if ($request->hasFile('img')) {
            // remove old image
            Storage::delete($collection->img_src);
            // add new image
            $resized_image_uri = $image->crop($request->img,1250, 1250);
            $path = Storage::putFile('public/collections', new File($resized_image_uri));

            //Now delete temporary intervention image as we have moved it to Storage folder with Laravel filesystem.
            unlink($resized_image_uri);
            $request->merge(['img_src'=>$path]);

            // Check for old featured images and delete accordingly
            if ($collection->featured) {
                Storage::delete($collection->featured_src);
            }

            // Check for any new images and add accordingly
            if ($request->featured == 'on') {
                $resized_featured_uri = $image->resize($request->img, 2220, 1210);
                $featured_path = Storage::putFile('public/collections', new File($resized_image_uri));
                unlink($resized_featured_uri);
                $request->merge(['featured_src'=>$featured_path]);
            }
        }
        
        flash('Successfully updated a Collection!')->success();
        $collection->update($request->all());
        return redirect()->route('collection.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Collection  $collectionController
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        // delete collection images

        if ($collection->img_src) {
            Storage::delete($collection->img_src);
        }

        // remove links to inventory items

        // delete collection
        if ($collection->delete()) {
            flash('You have successfully deleted a collection.')->success();
            return redirect()->route('collection.index');
        }
    }

    public function set(Collection $collection, Inventory $inventory)
    {
        $inventory_select = $inventory->prepareSelect();
        $inventories = $inventory->prepareForSet($collection->id);
        return view('collections.set', compact(['collection','inventory_select','inventories']));
    }

    public function add(Request $request, Collection $collection, Inventory $inventory)
    {
        $status = 'fail';
        if (!$collection->collectionItem()->where('inventory_item_id', $request->inventory_item_id)->exists()) {
            $status = 'success';
            $collection->collectionItem()->attach($request->inventory_item_id);
        }

        $inventories = $inventory->prepareForSet($collection->id);
        

        return response()->json([
            'status' => $status,
            'inventories' => $inventories
        ]);
    }

    public function remove(Request $request, Collection $collection, Inventory $inventory)
    {
        $add = $request->add;
        $send = $request->send;
        $status = 'fail';
        if ($collection->collectionItem()->where('inventory_item_id', $request->inventory_item_id)->exists()) {
            $status = 'success';
            $collection->collectionItem()->detach($request->inventory_item_id);
        }

        $inventories = $inventory->prepareForSet($collection->id);
        

        return response()->json([
            'status' => $status,
            'inventories' => $inventories
        ]);
    }
}
