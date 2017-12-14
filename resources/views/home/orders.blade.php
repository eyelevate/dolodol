@extends($layout)

@section('scripts')
<script type="text/javascript" src="{{ mix('/js/views/home/cart.js') }}"></script>
@endsection

@section('styles')

@endsection

@section('header')
@endsection

@section('content')

<div class="row justify-content-center">
  	<h3>Orders</h3>
</div>

<div class="container">

	<div class="row-fluid" >
	@if(isset($cart))
		@foreach($cart as $key => $item)
		<div class="media hidden-sm-down item" item-id="{{ $key }}">
			<img class="d-flex align-self-start mr-3 lazy" data-original="{{ asset($item['img_src']) }}" alt="Generic placeholder image" style="max-height:150px;">
			
			<div class="media-body">
				@if ($item['email'])
				<h5 class="mt-0">{{ $item['inventoryItem']['name'] }} <strong class="pull-right">Priced Later</strong></h5>
				@else
				<h5 class="mt-0">{{ $item['inventoryItem']['name'] }} <strong class="pull-right">${{ number_format($item['subtotal'],2,'.',',') }}</strong></h5>
				@endif
				<p>{{ $item['inventoryItem']['desc'] }}</p>
				<div class="table-responsive">		
					<small>
						<table class="table table-condensed">
							<tfoot class="text-muted">
								<tr>
									<td class="text-right" style="border:none; width:100px;">Quantity:&nbsp;</td>
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
								@if (!$item['email'])
									@if($item['inventoryItem']['sizes'])
									<tr >
										<td class="text-right" style="border:none;">Stone Size:&nbsp;</td>
										<th class="text-left" style="border:none;">{{ $item['size_name'] }}</th>
									</tr>
									@endif
								@endif
							</tfoot>
						</table>
					</small>		
				</div>
				<button class="btn btn-danger pull-right" @click="removeRow($event, {{ $key }})">Remove</button>
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
								@if (!$item['email'])
									@if($item['inventoryItem']['sizes'])
									<tr >
										<td class="text-right" style="border:none;">Stone Size:&nbsp;</td>
										<th class="text-left" style="border:none;">{{ $item['size_name'] }}</th>
									</tr>
									@endif
								@endif
								<tr>
									<td class="text-right" style="border:none;">Subtotal:&nbsp;</td>
									@if($item['email'])
									<th class="text-left" style="border:none;">Priced Later</th>
									@else
									<th class="text-left" style="border:none;">${{ number_format($item['subtotal'],2,'.',',') }}</th>
									@endif
								</tr>
							</tfoot>
						</table>
					</small>			
					
				</div>
				
			</div>
			<button class="btn btn-danger btn-block btn-sm" @click="removeRow($event,{{ $key }})">Remove</button>
		</div>
		<hr/>
		@endforeach
	@endif
	</div>


	{{-- <div class="row-fluid">
		<div class="table-responsive">
			<table class="table table-condensed">
				<tfoot>
					<tr>
						<td class="text-right" style="border:none;">Quantity:&nbsp;</td>
						<th class="text-left" style="border:none;">@{{ totals.quantity }}</th>
					</tr>
					<tr>
						<td class="text-right" style="border:none;">Subtotal:&nbsp;</td>
						@if ($email)
						<th class="text-left" style="border:none;" >Priced Later</th>
						@else
						<th class="text-left" style="border:none;" >@{{ totals.subtotal }}</th>
						@endif
					</tr>
					<tr>
						<td class="text-right" style="border:none;">Tax:&nbsp;</td>
						@if ($email)
						<th class="text-left" style="border:none;" >Priced Later</th>
						@else
						<th class="text-left" style="border:none;"> @{{ totals.tax }}</th>
						@endif
						
					</tr>
					<tr>
						<td class="text-right" style="border:none;">Total:&nbsp;</td>
						@if ($email)
						<th class="text-left" style="border:none;" >Priced Later</th>
						@else
						<th class="text-left" style="border:none;" >@{{ totals.total}}</th>
						@endif
						
					</tr>
				</tfoot>
			</table>
		</div>
	</div> --}}
	<hr/>
	<div class="row-fluid">
		<a role="button" class="btn btn-primary " href="{{ route('home') }}">Home</a>
		<a role="button" class="btn btn-info" href="{{ route('home.shop') }}">Continue Shopping</a>
	</div>

</div>


@endsection
@section('modals')
@endsection
@section('variables')
{{-- <div id="variable-root" totals="{{ json_encode($totals) }}">
	
</div> --}}
@endsection

