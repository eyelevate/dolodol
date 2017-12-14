@extends('layouts.themes.theme2.layout')

@section('scripts')
<script type="text/javascript" src="{{ mix('js/views/invoices/finish.js') }}"></script>
@endsection

@section('styles')
<style>

</style>


@endsection

@section('header')
@endsection

@section('content')
{!! Form::open(['method'=>'patch','route'=>['invoice.done',$invoice->id]]) !!}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
            <div class="customer-form">
                <div class="row justify-content-center hidden-sm-down">
                    <h1 class="lowmargin">Freya's Fine Jewelry</h1>
                </div>
                <div class="row justify-content-center hidden-sm-down">
                    <nav class="breadcrumb">
                        <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
                        <a class="breadcrumb-item" href="{{ route('home.shop') }}">Collections</a>
                        <a class="breadcrumb-item" href="{{ route('home.cart') }}">Shopping Cart</a>
                        <span class="breadcrumb-item active">Checkout</span>

                    </nav>
                </div>


                {{-- Customer Form --}}
                <div class="row">

                    <div class="text-center col-12">
                        <h5>Customer Information</h5>
                    </div>

                </div>
                
                {{-- Form Row 2 --}}
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group {{ $errors->has('first_name') ? ' has-danger' : '' }}">
                            <label class="form-control-label">First Name</label>
                            {{ Form::text('first_name', old('first_name') ? old('first_name') : $invoice->first_name,['class'=>'form-control']) }}
                            <div class="hidden-md-up {{ ($errors->has('first_name')) ? '' : 'hide' }}">
                                <small class="form-control-feedback">{{ $errors->first('first_name') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group {{ $errors->has('last_name') ? ' has-danger' : '' }}">
                            <label class="form-control-label">Last Name</label>
                            {{ Form::text('last_name', old('last_name') ? old('last_name') : $invoice->last_name,['class'=>'form-control']) }}
                        </div>
                        <div class="hidden-md-up {{ ($errors->has('last_name')) ? '' : 'hide' }}">
                            <small class="form-control-feedback">{{ $errors->first('last_name') }}</small>
                        </div>
                    </div>
                    <div class="hidden-sm-down {{ ($errors->has('first_name')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('first_name') }}</small>
                    </div>
                    <div class="hidden-sm-down {{ ($errors->has('last_name')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('last_name') }}</small>
                    </div>
                </div>
                {{-- Email --}}
                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                    <label class="form-control-label">Email</label>
                    {{ Form::text('email', old('email') ? old('email') : $invoice->email,['class'=>'form-control','type'=>'email']) }}
                    <div class="{{ ($errors->has('email')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('email') }}</small>
                    </div>
                </div>

                {{-- Phone --}}
                <div class="form-group {{ $errors->has('phone') ? ' has-danger' : '' }}">
                    <label class="form-control-label">Phone</label>
                    {{ Form::text('phone', old('phone') ? old('phone') : $invoice->phone,['class'=>'form-control']) }}
                    <div class="{{ ($errors->has('phone')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('phone') }}</small>
                    </div>
                </div>

                {{-- Shipping Address --}}
                <hr/>
                <div class="row">

                    <div class="text-center col-12">
                        <h5>Shipping Address</h5>
                    </div>

                </div>
                {{-- Form Row 4 --}}
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        {{-- street --}}
                        <div class="form-group {{ $errors->has('street') ? ' has-danger' : '' }}">
                            <label class="form-control-label">Street</label>
                            {{ Form::text('street', old('street') ? old('street') : $invoice->street,['class'=>'form-control']) }}
                            <div class="{{ ($errors->has('street')) ? '' : 'hide' }}">
                                <small class="form-control-feedback">{{ $errors->first('street') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        {{-- suite --}}
                        <div class="form-group {{ $errors->has('suite') ? ' has-danger' : '' }}">
                            <label class="form-control-label">Suite</label>
                            {{ Form::text('suite', old('suite') ? old('suite') : $invoice->suite,['class'=>'form-control']) }}
                            <div class="{{ ($errors->has('suite')) ? '' : 'hide' }}">
                                <small class="form-control-feedback">{{ $errors->first('suite') }}</small>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- city--}}
                <div class="form-group {{ $errors->has('city') ? ' has-danger' : '' }}">
                    <label class="form-control-label">City</label>
                    {{ Form::text('city', old('city') ? old('city') : $invoice->city,['class'=>'form-control']) }}
                    <div class="{{ ($errors->has('city')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('city') }}</small>
                    </div>
                </div>
                {{-- Form Row 6 --}}
                <div class="row form-group">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        {{-- state --}}
                        <div class="form-group {{ $errors->has('state') ? ' has-danger' : '' }}">
                            <label class="form-control-label">State</label>
                            {{ Form::select('state', $states ,old('state') ? old('state') :  $invoice->state,['class'=>'form-control']) }}
                            <div class="hidden-sm-down {{ ($errors->has('state')) ? '' : 'hide' }}">
                                <small class="form-control-feedback">{{ $errors->first('state') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        {{-- country --}}
                        <div class="form-group {{ $errors->has('country') ? ' has-danger' : '' }}">
                            <label class="form-control-label">Country</label>
                            {{ Form::select('country', $countries ,old('country') ? old('country') : $invoice->country,['class'=>'form-control']) }}
                            <div class="hidden-sm-down {{ ($errors->has('country')) ? '' : 'hide' }}">
                                <small class="form-control-feedback">{{ $errors->first('country') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="hidden-md-up {{ ($errors->has('state')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('state') }}</small>
                    </div>
                    <div class="hidden-md-up {{ ($errors->has('country')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('country') }}</small>
                    </div>
                </div>
                {{-- zipcode --}}
                <div class="form-group {{ $errors->has('zipcode') ? ' has-danger' : '' }}">
                    <label class="form-control-label">Zipcode</label>
                    {{ Form::text('zipcode', old('zipcode') ? old('zipcode') : $invoice->zipcode,['class'=>'form-control']) }}
                    <div class="{{ ($errors->has('zipcode')) ? '' : 'hide' }} hidden-sm-down">
                        <small class="form-control-feedback">{{ $errors->first('zipcode') }}</small>
                    </div>
                </div>
                
                <hr/>
                <div class="row">

                    <div class="col-12">
                        <h5 class="text-center">Shipping Options</h5>
                        <small>
                            <blockquote class="blockquote">
                                <p class="mb-0">All shipping will dates will be calculated from the moment your item is ready to be shipped. Custom designs and certified / lab created diamonds can require up 8 weeks from point of sale. Please keep in mind we will ship out as soon as the item is in perfect order and keep in communication all along the way!</p>
                            </blockquote>
                        </small>
                    </div>

                </div>
                <div class="row-fluid">
                    <div class="col-12">
                        
                        <label class="form-control-label">
                            <input type="radio" disabled name="shipping" value="1" {{ (old('shipping') == 1 || $invoice->shipping == 1) ? 'checked' : '' }} @click="updateShipping(1)">
                            &nbsp;2 Day
                        </label>
                    </div>

                    <div class="col-12">
                        
                        <label class="form-control-label">
                            <input type="radio" disabled name="shipping" value="2" {{ (old('shipping') == 2 || $invoice->shipping == 2) ? 'checked' : '' }} @click="updateShipping(2)">
                            &nbsp;Next Day
                        </label>
                    </div>
                </div>
                <hr/>
                <div class="row">

                    <div class="col-12 text-center">
                        <h5>Payment Information</h5>
                    </div>
                </div>
                <div class="row-fluid text-center">
                    
                    <label class="form-control-label">
                        <input type="checkbox" @click="sameAsShipping($event)" />    
                        &nbsp;Click if same as shipping address.
                    </label>
                </div>
                <div class="form-group row">

                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        {{-- street --}}
                        <div class="form-group {{ $errors->has('billing_street') ? ' has-danger' : '' }}">
                            <label class="form-control-label">Billing Street</label>

                            {{ Form::text('billing_street', old('billing_street') ? old('billing_street') : $invoice->street,['class'=>'form-control']) }}   
                            
                            <div class="{{ ($errors->has('billing_street')) ? '' : 'hide' }}">
                                <small class="form-control-feedback">{{ $errors->first('billing_street') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        {{-- suite --}}
                        <div class="form-group {{ $errors->has('billing_suite') ? ' has-danger' : '' }}">
                            <label class="form-control-label">Billing Suite</label>
                            {{ Form::text('billing_suite', old('billing_suite') ? old('billing_suite') : $invoice->suite,['class'=>'form-control']) }}
                            <div class="{{ ($errors->has('billing_suite')) ? '' : 'hide' }}">
                                <small class="form-control-feedback">{{ $errors->first('s') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- city--}}
                <div class="form-group {{ $errors->has('billing_city') ? ' has-danger' : '' }}">
                    <label class="form-control-label">Billing City</label>
                    {{ Form::text('billing_city', old('billing_city') ? old('billing_city') : $invoice->city,['class'=>'form-control']) }}
                    <div class="{{ ($errors->has('billing_city')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('billing_city') }}</small>
                    </div>
                </div>
                {{-- Form Row 6 --}}
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        {{-- state --}}
                        <div class="form-group {{ $errors->has('billing_state') ? ' has-danger' : '' }}">
                            <label class="form-control-label">Billing State</label>
                            {{ Form::select('billing_state', $states ,old('billing_state') ? old('billing_state') :  $invoice->state,['class'=>'form-control']) }}
                            <div class="hidden-sm-down {{ ($errors->has('billing_state')) ? '' : 'hide' }}">
                                <small class="form-control-feedback">{{ $errors->first('billing_state') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        {{-- country --}}
                        <div class="form-group {{ $errors->has('billing_country') ? ' has-danger' : '' }}">
                            <label class="form-control-label">Billing Country</label>
                            {{ Form::select('billing_country', $countries ,old('country') ? old('country') : $invoice->country,['class'=>'form-control']) }}
                            <div class="hidden-sm-down {{ ($errors->has('billing_country')) ? '' : 'hide' }}">
                                <small class="form-control-feedback">{{ $errors->first('billing_country') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="hidden-md-up {{ ($errors->has('billing_state')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('billing_state') }}</small>
                    </div>
                    <div class="hidden-md-up {{ ($errors->has('billing_country')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('billing_country') }}</small>
                    </div>
                </div>
                {{-- zipcode --}}
                <div class="form-group {{ $errors->has('billing_zipcode') ? ' has-danger' : '' }}">
                    <label class="form-control-label">Billing Zipcode</label>
                    {{ Form::text('billing_zipcode', old('billing_zipcode') ? old('billing_zipcode') : $invoice->zipcode,['class'=>'form-control']) }}
                    <div class="{{ ($errors->has('billing_zipcode')) ? '' : 'hide' }} hidden-sm-down">
                        <small class="form-control-feedback">{{ $errors->first('billing_zipcode') }}</small>
                    </div>
                </div>

                {{-- card --}}
                <div class="form-group {{ $errors->has('card_number') ? ' has-danger' : '' }}">
                    <label class="form-control-label">Credit Card Number</label>
                    {{ Form::text('card_number', old('card_number') ? old('card_number') : '',['class'=>'form-control']) }}
                    <div class="{{ ($errors->has('card_number')) ? '' : 'hide' }} hidden-sm-down">
                        <small class="form-control-feedback">{{ $errors->first('card_number') }}</small>
                    </div>
                </div>
                {{-- Expiration --}}
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group {{ $errors->has('exp_month') ? ' has-danger' : '' }}">
                            <label class="form-control-label">Expiration Month</label>
                            {{ Form::text('exp_month', old('exp_month') ? old('exp_month') : '',['class'=>'form-control','maxlength'=>2,'placeholder'=>'MM']) }}

                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group {{ $errors->has('exp_year') ? ' has-danger' : '' }}">
                            <label class="form-control-label">Expiration Year</label>
                            {{ Form::text('exp_year', old('exp_year') ? old('exp_year') :'',['class'=>'form-control','maxlength'=>4,'placeholder'=>'YYYY']) }}
                        </div>
     
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group {{ $errors->has('cvv') ? ' has-danger' : '' }}">
                            <label class="form-control-label">CVV (back of card)</label>
                            {{ Form::text('cvv', old('cvv') ? old('cvv') :'',['class'=>'form-control','maxlength'=>4,'placeholder'=>'cvv']) }}
                        </div>

                    </div>
                    
                </div>

                <div class="row-fluid text-danger">
                    <ul class="col-12">
                        <li class="{{ ($errors->has('exp_month')) ? '' : 'hide' }}">
                            <small class="form-control-feedback">{{ $errors->first('exp_month') }}</small>
                        </li>
                        <li class="{{ ($errors->has('exp_year')) ? '' : 'hide' }}">
                            <small class="form-control-feedback">{{ $errors->first('exp_year') }}</small>
                        </li>
                        <li class="{{ ($errors->has('cvv')) ? '' : 'hide' }}">
                            <small class="form-control-feedback">{{ $errors->first('cvv') }}</small>
                        </li>
                    </ul>
                </div>
            </div>
            <hr/>
        </div>

        {{-- Customer Order Summary Sidebar --}}

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 order-summary">
            @if(isset($cart))
                @foreach($cart as $key => $item)
                <div class="row-fluid">
                    
                    <div class="media  hidden-sm-down item" item-id="{{ $key }}">
                        <img class="d-flex align-self-start mr-3 lazy" data-original="{{ asset($item['img_src']) }}" alt="Generic placeholder image" style="max-height:75px;">
                        
                        <div class="media-body">
                            <h5 class="mt-0">{{ $item['inventoryItem']['name'] }}</h5>
                            <p>{{ $item['inventoryItem']['desc'] }}</p>
                            <div class="table-responsive">
                                <small>         
                                    <table class="table table-condensed">
                                        <tfoot class="text-muted">
                                            <tr>
                                                <td class="text-right" style="border:none; width:100px;">Quantity:&nbsp;</td>
                                                <th class="text-left" style="border:none;">{{ $item['quantity'] }}</th>
                                            </tr>
                                            @if(isset($item['finger_id']))
                                            <tr>
                                                <td class="text-right" style="border:none;">Ring Size:&nbsp;</td>
                                                <th class="text-left" style="border:none;">{{ $item['ring_size'] }}</th>
                                            </tr>
                                            @endif
                                            @if(isset($item['metal_type']))
                                            <tr>
                                                <td class="text-right" style="border:none;">Metal Type:&nbsp;</td>
                                                <th class="text-left" style="border:none;">{{ $item['metal_name'] }}</th>
                                            </tr>
                                            @endif
                                            @if(isset($item['stone_type']))
                                            <tr>
                                                <td class="text-right" style="border:none;">Stone Type:&nbsp;</td>
                                                <th class="text-left" style="border:none;">{{ $item['stone_type'] }}</th>
                                            </tr>
                                            @endif

                                            @if(isset($item['size_name']))
                                            <tr >
                                                <td class="text-right" style="border:none;">Stone Size:&nbsp;</td>
                                                <th class="text-left" style="border:none;">{{ $item['size_name'] }}</th>
                                            </tr>
                                            @endif

                                            <tr>
                                                <td class="text-right" style="border:none;">Subtotal:&nbsp;</td>
                                                <th class="text-left" style="border:none;">{{ '$'.number_format($item['subtotal'],2,'.',',') }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card hidden-md-up item" item-id="{{ $key }}">

                        <img class="cart-img-top img-fluid mx-auto d-block lazy" data-original="{{ asset($item['img_src']) }}" alt="Generic placeholder image" style="max-height:150px;">
                        <div class="card-block">
                            <h5 class="mt-0 text-center">{{ $item['inventoryItem']['name'] }}</h5>
                            <p>{{ $item['inventoryItem']['desc'] }}</p>
                            <div class="table-responsive"> 
                                <small>             
                                    <table class="table table-condensed">
                                        <tfoot class="text-muted">
                                            <tr>
                                                <td class="text-right" style="border:none;">Quantity:&nbsp;</td>
                                                <th class="text-left" style="border:none;">{{ $item['quantity'] }}</th>
                                            </tr>
                                            @if($item['inventoryItem']['fingers'])
                                            <tr>
                                                <td class="text-right" style="border:none;">Ring Size:&nbsp;</td>
                                                <th class="text-left" style="border:none;">{{ $item['ring_size'] }}</th>
                                            </tr>
                                            @endif
                                            @if($item['inventoryItem']['metals'])
                                            <tr>
                                                <td class="text-right" style="border:none;">Metal Type:&nbsp;</td>
                                                <th class="text-left" style="border:none;">{{ $item['metal_name'] }}</th>
                                            </tr>
                                            @endif
                                            @if($item['inventoryItem']['stones'])
                                            <tr>
                                                <td class="text-right" style="border:none;">Stone Type:&nbsp;</td>
                                                <th class="text-left" style="border:none;">{{ $item['stone_type'] }}</th>
                                            </tr>
                                            @endif

                                            @if($item['inventoryItem']['sizes'])
                                            <tr >
                                                <td class="text-right" style="border:none;">Stone Size:&nbsp;</td>
                                                <th class="text-left" style="border:none;">{{ $item['size_name'] }}</th>
                                            </tr>
                                            @endif
  
                                            <tr>
                                                <td class="text-right" style="border:none;">Subtotal:&nbsp;</td>
                                                <th class="text-left" style="border:none;">${{ number_format($item['subtotal'],2,'.',',') }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                @endforeach
            @endif
            <div class="row-fluid">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <tfoot>
                            <tr>
                                <td class="text-right" style="border:none;">Quantity:&nbsp;</td>
                                <th class="text-left" style="border:none;">@{{ totals.quantity }}</th>
                            </tr>
                            <tr>
                                <td class="text-right" style="border:none;">Subtotal:&nbsp;</td>
                                <th class="text-left" style="border:none;" >@{{ totals.subtotal }}</th>

                            </tr>
                            <tr>
                                <td class="text-right" style="border:none;">Tax:&nbsp;</td>
                                <th class="text-left" style="border:none;"> @{{ totals.tax }}</th>
                            </tr>
                            <tr>
                                <td class="text-right" style="border:none;">Shipping:&nbsp;</td>
                                <th class="text-left" style="border:none;"> @{{ totals.shipping }}</th>
                            </tr>
                            <tr>
                                <td class="text-right" style="border:none;">Total:&nbsp;</td>
                                <th class="text-left" style="border:none;" >@{{ totals.total}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <hr/>
            {{-- Mail Test --}}
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-success btn-block" type="submit" v-if="totals.quantity > 0">Complete Transaction</button>
                    <button class="btn btn-success btn-block" disabled type="submit" v-else>Complete Transaction</button>
                </div>
            </div>
            <hr/>

            <div class="row align-items-center">
                <div class="col-6">
                    <a href="{{ route('home.cart') }}" class="btn btn-primary btn-block">Return to Cart</a>
                </div>
                <div class="col-6">
                    <a href="#" class="btn btn-primary btn-block">Refund Policy</a>
                </div>
            </div>
            <hr/>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection
@section('modals')


@endsection
@section('variables')
<div id="variable-root" 
    totals="{{ json_encode($totals) }}"></div>
@endsection
