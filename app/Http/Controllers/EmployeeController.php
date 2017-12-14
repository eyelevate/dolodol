<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $role = 4;
        $columns = $user->prepareTableColumns();
        $rows = $user->prepareTableRows($user->where('role_id','<', $role)->get(), $role);
        // $rows = $user->prepareTableRows($user->all());
        return view('employees.index', compact(['columns','rows']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create and save the user.
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id'=>3
        ]);

        // Redirect to the previous page.

        flash('You successfully created a new employee.')->success();
        
        return redirect()->route('employee.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($employee = null, User $user)
    {
        $employee = $user->find($employee);

        if ($employee->role_id > 1) {
            if (auth()->user()->id != $employee->id) {
                flash('You do not have access to change this employees information. Please contact administrator');
                return redirect()->back();
            }
        }

        return view('employees.edit', compact('employee'));

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employee = null, User $user)
    {
        $employee = $user->find($employee);
           //Check if the user enters the password.
        if (trim($request->password) == '') {
            //Validate the form
            $this->validate(request(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|string|email|max:255'
            ]);

            $employee->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email
            ]);
        } else {
            //Validate the form
            $this->validate(request(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6|confirmed',
            ]);
            $employee->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        }

        // Create and save the user.


        // Redirect to the previous page.
        flash('You successfully updated the employee.')->success()->important();
        
        return redirect()->route('employee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $employee)
    {
        if ($client->delete()) {
            flash('You have successfully deleted a customer.')->success()->important();
            return redirect()->route('employee.index');
        }
    }
}
