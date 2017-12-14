@extends('layouts.themes.pdfs.layout')

@section('content')

		<div class="grid-x" style="clear:both;">
			<div class="small-6 medium-6 large-6 cell">
				<h4 >{{ $company->name }}</h4>
				<address style="line-height: 1; font-weight:100 !important; font-size:15px !important;">
					{{ $company->street }}, Suite {{ $company->suite }}<br>
					{{ ucfirst($company->city) }}, {{ strtoupper($company->state) }} {{ $company->zipcode }}<br>
					<abbr title="Phone">P:&nbsp;{{ $company->phone }}</abbr> 
				</address>
			</div>
			<div class="auto  cell" style="float:right;line-height:1px; ">
				<h3>INVOICE #{{ $inv->id_formatted }}</h3>
				
			</div>
			
		</div>
		<br/><br/><br/><br/>
		<div class="grid-x" >
			<div class="cell" >
				<h4 >{{ $inv->full_name }}</h4>
				<address style="line-height: 1; font-weight:100 !important; font-size:15px !important;">
					{{ $inv->full_street }}<br>
					{{ ucfirst($inv->city) }}, {{ strtoupper($inv->state) }} {{ $inv->zipcode }}<br>
					<abbr title="Phone">P:&nbsp;{{ $inv->phone_formatted }}</abbr> 
				</address>
			</div>
		</div>
		<br/><br/><br/>
		<div class="grid-x">
			<table class="unstriped">
				<thead>
					<tr>
						<th class="text-center" width="100">Quantity</th>
						<th>Description</th>
						<th width="150">Subtotal</th>
					</tr>
				</thead>
				<tbody>
				@if(count($inv) > 0)
					@foreach($inv->invoiceItems as $ii)
					<tr>
						<td class="text-center">{{ $ii->quantity }}</td>
						<td>{{ $ii->inventoryItem->name }} - {{ $ii->inventoryItem->desc }}</td>
						<td>{{ $ii->subtotal_formatted }}</td>
					</tr>
					@endforeach
				@endif
				</tbody>
				<tfoot style="">

					<tr>
						<th class="text-right" colspan="2" style="font-weight:bold !important;">Quantity:</th>
						<td>{{ $inv->quantity }}</td>
					</tr>
					<tr>
						<th class="text-right" colspan="2" style="font-weight:bold !important;">Subtotal:</th>
						<td>{{ $inv->subtotal_formatted }}</td>
					</tr>
					<tr>
						<th class="text-right" colspan="2" style="font-weight:bold !important;">Tax:</th>
						<td>{{ $inv->tax_formatted }}</td>
					</tr>
					<tr>
						<th class="text-right" colspan="2" style="font-weight:bold !important;">Shipping:</th>
						<td>{{ $inv->shipping_total_formatted }} ({{ $inv->shipping_type }})</td>
					</tr>
					<tr>
						<th class="text-right" colspan="2" style="font-weight:bold !important;">Total Due:</th>
						<td style="font-weight:bold !important;">{{ $inv->total_formatted }}</td>
					</tr>
					@if($inv->status > 2)
					<tr>
						<th class="text-right" colspan="2" style="font-weight:bold !important;">Tendered:</th>
						<td style="font-weight:bold !important;">{{ $inv->tendered_formatted }}</td>
					</tr>
					<tr>
						<th class="text-right" colspan="2" style="font-weight:bold !important;">Due:</th>
						<td style="font-weight:bold !important;">{{ $inv->due_formatted }}</td>
					</tr>
					@endif
				</tfoot>
			</table>
		</div>
		<div class="grid-x" >
			<div class="cell">
				<p class="text-center" style="font-size:14px !important; font-weight:lighter !important;">Make all checks payable to <span style="font-weight:bold !important;">{{ $company->name }}</span></p>
				<p class="text-center" style="font-size:14px !important; font-weight:lighter !important;">If you have any questions or concerns please call us at <span style="font-weight:bold !important;">{{ $company->phone }}</span></p>
			</div>
		</div>

	


@endsection
