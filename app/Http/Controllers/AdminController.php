<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceItem;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Invoice $invoice, InvoiceItem $invoiceItem)
    {

        return view('admins.index');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login()
    {

        if (auth()->check()) {
            
            return redirect()->route('admin.index');
        }
        return view('admins.login');
    }

    public function authenticate(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            if (Auth::user()->role_id > 3) {
                flash()->message('Successfully logged in, however, you are not authorized to view this page.')->warning();
                return redirect()->route('home.index');
            } else {
                flash()->message('Successfully logged in as '.Auth::user()->email.'!')->success();
                return (session()->has('intended_url')) ? redirect()->to(session()->get('intended_url')) : redirect()->intended('/admins');
            }
        } else {
            flash()->message('Could not log you in please try again..')->error();
            // Auth::logout();
            return redirect()->route('admin.login');
        }
    }

    public function logout(User $user)
    {
        if (Auth::check()) {
            Auth::logout();
            flash()->message('Successfully logged out!')->success();
        } else {
            flash()->message('Warning: no instances of a logged in session remaining. Please try logging in again.')->warning();
        }

        return redirect()->route('admin.login');
    }
}
