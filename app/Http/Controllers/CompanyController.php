<?php

namespace App\Http\Controllers;

use App\Company;
use App\Job;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company, Job $job)
    {
        $columns = $company->prepareTableColumns();
        $rows = $company->prepareTableRows($company->orderBy('name', 'asc')->get());
        $days = $job->prepareDays();
        return view('companies.index', compact(['columns','rows','days']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Job $job)
    {
        $states = $job->prepareStates();
        $countries = $job->prepareCountries();
        $hours = $job->prepareHours();
        $minutes = $job->prepareMinutes();
        $ampm = $job->prepareAmpm();
        $open = $job->prepareOpen();
        return view('companies.create', compact(['states','countries','hours','minutes','ampm','open']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:companies',
        ]);
        $request->merge(['hours'=>json_encode($request->hours)]);
        $company->create(request()->all());
        flash('Successfully created a Company!')->success();
        
        return redirect()->route('company.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, Job $job)
    {
        $company->hours = json_decode($company->hours);
        $states = $job->prepareStates();
        $countries = $job->prepareCountries();
        $hours = $job->prepareHours();
        $minutes = $job->prepareMinutes();
        $ampm = $job->prepareAmpm();
        $open = $job->prepareOpen();
        $days = $job->prepareDays();

        return view('companies.edit', compact(['company','states','countries','hours','minutes','ampm','open','store','days']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //Validate the form
        //Validate the form
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:255',
        ]);
        $request->merge(['hours'=>json_encode($request->hours)]);
        $company->update($request->all());
        flash('Successfully updated company!')->success();
        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if ($collection->delete())
        {
            flash('You have successfully deleted a collection.')->success();
            return redirect()->route('collection.index');
        }
    }
}
