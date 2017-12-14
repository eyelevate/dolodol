@extends('layouts.themes.backend.layout')
@section('styles')	
@endsection
@section('scripts')
<script type="text/javascript" src="{{ mix('/js/views/admins/home.js') }}"></script>
@endsection

@section('content')
<!-- Breadcrumb -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Invoices </li>
</ol>
<div class="container-fluid">
	
	<bootstrap-card use-header="true" use-body="true" use-footer="true">
		
		<template slot="header">Invoices </template>
		
		<template slot="body">
			<div class="table-responsive">
				<bootstrap-table
					:columns="{{ $columns }}"
					:rows="{{ $rows }}"
					:paginate="true"
					:global-search="true"
					:line-numbers="true"/>
				</bootstrap-table>
		    </div>
		</template>

		<template slot="footer">
			<a href="{{ route('invoice.create') }}" class="btn btn-primary">Create Invoice</a>
		</template>

	</bootstrap-card>
	
</div>
@endsection

@section('modals')
@if (count($invoiceDetails) > 0)
    @foreach($invoiceDetails as $dkey => $detail)
    <bootstrap-modal id="viewModal-{{ $detail->id }}" b-size="modal-lg">
        <template slot="header">Invoice - #{{ str_pad($detail->id,6,0,STR_PAD_LEFT) }}</template>
        <template slot="body">
            <div class="container">
                <h3 class="text-center">Invoice Progress</h3>
                <div class="progress">
                    @if ($detail->status == 1)
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    @elseif($detail->status==2)
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    @else
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    @endif
                </div>
                <hr/>
                <h3 class="text-center">Invoice Details</h3>
                <div class="table-responsive">
                    <table class="table table-outline table-condensed">
                        <tbody>
                            <tr>
                                <th>Invoice #</th>
                                <td>{{ str_pad($detail->id,6,0,STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr>
                                <th>Client</th>
                                <td>{{ $detail->full_name }}</td>
                            </tr>
                            <tr>
                                <th>Shipping Address</th>
                                <td>{!! $detail->shipping_address !!}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{!! $detail->phone !!}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{!! $detail->email !!}</td>
                            </tr>
                            <tr>
                                <th>Quantity</th>
                                <td>{!! $detail->quantity !!}</td>
                            </tr>
                            <tr>
                                <th>Subtotal</th>
                                <td id="subtotal-{{ $dkey }}">${!! number_format($detail->subtotal,2,'.',',') !!}</td>
                            </tr>
                            <tr>
                                <th>Tax</th>
                                <td id="tax-{{ $dkey }}">${!! number_format($detail->tax,2,'.',',') !!}</td>
                            </tr>
                            <tr>
                                <th>Shipping</th>
                                <td >
                                    @if($detail->status == 2)
                                    <div class="input-group">
                                        <input class="form-control" type="text" value="{{ $detail->shipping_total }}"  placeholder="update shipping total here">
                                        <div class="input-group-addon btn btn-primary" @click="updateShipping({{ $dkey }}, $event)">Set</div>
                                    </div>
                                    
                                    <span id="shippingError-{{ $dkey }}" class="text-danger"></span>   
                    
                                    @else
                                    ${!! number_format($detail->shipping_total,2,'.',',') !!} <strong>({{ $detail->shipping_type }})</strong> 
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td id="total-{{ $dkey }}">${!! number_format($detail->total,2,'.',',') !!}</td>
                            </tr>
                            <tr>
                                <th>Payment Type</th>
                                <td>{{ $detail->payment_type }}</td>
                            </tr>

                            <tr>
                                <th>Last Four</th>
                                <td>{{ $detail->last_four }}</td>
                            </tr>
                            <tr>
                                <th>Transaction ID #</th>
                                <td>{{ $detail->transaction_id }}</td>
                            </tr>
                            

                        </tbody>
                    </table>
                </div>
                <hr/>
                <h3 class="text-center">Invoice Item Details</h3>
                <div class="table-responsive">
                @if (count($detail->invoiceItems) > 0)
                    @foreach($detail->invoiceItems as $item)
                        @if (isset($item->inventoryItem))
                        <table class="table table-outline table-condensed">
                            <tbody>

                                <tr>
                                    <th>Item Name</th>
                                    <td><a href="{{ route('inventory_item.edit',$item->inventoryItem->id) }}" target="__blank">{{ $item->inventoryItem->name }}</a></td>
                                </tr>
                                <tr>
                                    <th>Quantity</th>
                                    <td>{{ $item->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Metal Type</th>
                                    @if (isset($item->itemMetal))
                                    <td>{{ $item->itemMetal->metals->name }}</td>
                                    @else
                                    <td>N/A</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Stone Type</th>
                                    @if(isset($item->itemStone))
                                    <td>{{ $item->itemStone->stones->name }}</td>
                                    @else
                                    <td>N/A</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Stone Size</th>
                                    @if(isset($item->itemSize))
                                        @if(isset($item->itemSize->stoneSizes))
                                        <td>{{ $item->itemSize->stoneSizes->sizes->name }}</td>
                                        @else
                                        <td>N/A</td>
                                        @endif
                                    @else
                                    <td>N/A</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Finger Size</th>
                                    @if(isset($item->finger_id))
                                    <td>{{ $item->fingers->name }}</td>
                                    @else
                                    <td>N/A</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Subtotal</th>      
                                    <td>${{ number_format($item->subtotal,2,'.',',') }}</td>
                                </tr>
                                @if ($detail->status == 2)
                                <tr>
                                    <td colspan="2">
                                        <a href="{{ route('invoice_item.edit',$item->id) }}" class="btn btn-info btn-block" >Edit Item</a>  
                                    </td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                        @endif
                    @endforeach
                @endif
                </div>
                
                <hr/>
                <h3 class="text-center">Invoice Actions</h3>
                <div class="row-fluid">
                    <a type="button" class="btn btn-inverse btn-block" target="__blank" href="{{ route('invoice.show_invoice_pdf',$detail->id) }}">Print Invoice PDF</a>  
                </div>
                <hr/>
                @if ($detail->status == 3)
                <div class="row-fluid">
                    <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#completeModal-{{ $detail->id }}">Complete Invoice</button>  
                </div>
                <hr/>
                <div class="row-fluid">
                    <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#refundModal-{{ $detail->id }}">Refund Only</button>  
                </div>
                <hr/>
                @endif
                @if($detail->status == 2)
                <div class="row-fluid">
                    {!! Form::open(['method'=>'post','route'=>['invoice.email',$detail->id]]) !!}
                    <button type="submit" class="btn btn-warning btn-block" >Email Invoice</button>  
                    {!! Form::close() !!}
                </div>
                <hr/>
                @endif
                @if ($detail->status < 5)
                <div class="row-fluid">
                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal-{{ $detail->id }}">{{ ($detail->status == 3) ? 'Cancel Invoice & Refund' : 'Cancel Invoice' }}</button>  
                </div>
                @else

                <div class="row-fluid">
                    <button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#revertModal-{{ $detail->id }}">Revert Status</button>  
                </div>
                @endif
            </div>
        </template>
        <template slot="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
            <a href="{{ route('invoice.edit',$detail->id) }}" class="btn btn-primary">Edit</a>
        </template>
    </bootstrap-modal>
    {{-- Cancel & Refund --}}
    {!! Form::open(['method'=>'delete','route'=>['invoice.destroy',$detail->id]]) !!}
    <bootstrap-modal id="deleteModal-{{ $detail->id }}">
        <template slot="header">Cancel Confirmation</template>
        <template slot="body">
            Are you sure you wish to cancel & refund invoice #{{ str_pad($detail->id,6,0,STR_PAD_LEFT) }}?
        </template>
        <template slot="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Proceed</button>    
        </template>
    </bootstrap-modal>
    {!! Form::close() !!}
    {{-- Refund Only --}}
    {!! Form::open(['method'=>'post','route'=>['invoice.refund',$detail->id]]) !!}
    <bootstrap-modal id="refundModal-{{ $detail->id }}">
        <template slot="header">Refund Confirmation</template>
        <template slot="body">
            Are you sure you wish to refund invoice #{{ str_pad($detail->id,6,0,STR_PAD_LEFT) }}?
        </template>
        <template slot="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Proceed</button>    
        </template>
    </bootstrap-modal>
    {!! Form::close() !!}
    {{-- complete --}}
    {!! Form::open(['method'=>'patch','route'=>['invoice.complete',$detail->id]]) !!}
    <bootstrap-modal id="completeModal-{{ $detail->id }}">
        <template slot="header">Complete Confirmation</template>
        <template slot="body">
            Click proceed to complete this invoice #{{ str_pad($detail->id,6,0,STR_PAD_LEFT) }}?
        </template>
        <template slot="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Proceed</button>    
        </template>
    </bootstrap-modal>
    {!! Form::close() !!}

    {{-- Revert --}}
    {!! Form::open(['method'=>'patch','route'=>['invoice.revert',$detail->id]]) !!}
    <bootstrap-modal id="revertModal-{{ $detail->id }}">
        <template slot="header">Revert Status</template>
        <template slot="body">
            Click to proceed in reverting status back from <span class="badge badge-default">Complete</span> to <span class="badge badge-success">Paid</span>.
        </template>
        <template slot="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Proceed</button>    
        </template>
    </bootstrap-modal>
    {!! Form::close() !!}

    @endforeach
@endif
@endsection

@section('variables')
<div id="variable-root"
    invoices="{{ json_encode($invoiceDetails) }}"
></div>
@endsection
