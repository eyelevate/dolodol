<?php

namespace App\Http\Controllers;

use App\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tax $tax)
    {
        $columns = $tax->prepareTableColumns();
        $rows = $tax->prepareTableRows($tax->all());

        return view('taxes.index',compact(['columns','rows']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('taxes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tax $tax)
    {
        $this->validate(request(), [
            'rate' => 'required'
        ]);

        $tax->create($request->all());
        flash('Successfully created a new tax rate')->success();
        return redirect()->route('tax.index');
    }

}
