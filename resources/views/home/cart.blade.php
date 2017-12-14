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
  	<h3>Shopping Cart</h3>
</div>

<div class="container">

	<div class="row-fluid">
		
	
	@if(isset($cart))
		@foreach($cart as $key => $item)
		<div class="d-none d-md-block item" item-id="{{ $key }}">
			<div class="media ">
				<span class="badge badge-default">{{ $key + 1 }}</span>
				<img class="d-flex mr-3 lazy " data-original="{{ asset($item['img_src']) }}" alt="image" style="max-height:150px;">
				<div class="media-body">
					<h5 class="mt-0">{{ $item['inventoryItem']['name'] }} <strong class="pull-right">${{ number_format($item['subtotal'],2,'.',',') }}</strong></h5>
					{{ $item['inventoryItem']['desc'] }}
					<div class="table-responsive">		
						<small>
							<table class="table table-condensed">
								<tfoot class="text-muted">
									<tr>
										<td class="text-right" style="border:none; width:100px;">Quantity:&nbsp;</td>
										<th class="text-left" style="border:none;">{{ $item['quantity'] }}</th>
									</tr>
						
								</tfoot>
							</table>
						</small>		
					</div>
					<button class="btn btn-danger pull-right" @click="removeRow($event, {{ $key }})">Remove</button>
				</div>
			</div>	
		</div>
		

		
		<div class="card d-md-none item" item-id="{{ $key }}">
			<span class="badge badge-default">{{ $key + 1 }}</span>
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

								<tr>
									<td class="text-right" style="border:none;">Subtotal:&nbsp;</td>
									<th class="text-left" style="border:none;">${{ number_format($item['subtotal'],2,'.',',') }}</th>
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
						<td class="text-right" style="border:none;">Total:&nbsp;</td>
						<th class="text-left" style="border:none;" >@{{ totals.total}}</th>
						
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<hr/>
	<div class="row-fluid">
		<a role="button" class="btn btn-secondary" href="{{ route('home.shop') }}">Back</a>
		<a role="button" class="btn btn-info " href="{{ route('home.checkout') }}">Checkout</a>


	</div>

</div>


@endsection
@section('modals')
@endsection
@section('variables')
<div id="variable-root" totals="{{ json_encode($totals) }}">
	
</div>
@endsection

