@extends($layout)
@section('scripts')
<script type="text/javascript" src="{{ mix('js/views/home/shop.js') }}"></script>
@endsection
@section('styles')
@endsection
@section('header')
<!-- <div class="container">
	<div class="row-fluid" style="">
		<theme1-shop-card 
			use-body="true" 
			use-img-top="true" 
			img-top-div-class="shop-header"
			img-top-src="img/theme2/BBshopHeader.jpg">
			<template slot="body">
				<div class="text-center">
					<blockquote class="blockquote">
						<p class="mb-0 text-left">We believe that choosing a conflict free center stone sets the bar high!  Whether your center stone is lab grown, ethically sourced or inherited, we take extra care in building sustainable and beautiful rings that meet your high standards! 
						</p>
					</blockquote>
				</div>
				
			</template>
		</theme1-shop-card>
	</div>
</div> -->
@endsection
@section('content')
<div class="container" style="margin-top:1.5em;">
	<h3 class="text-center">OUR COLLECTIONS</h3>
	<div class="row">
		@if (count($collections) > 0)
			@foreach($collections as $collection)
			<theme1-shop-card 
			class="col-xs-12 col-sm-6 col-md-6 col-lg-4"
			use-body="true" 
			use-img-top="true" 
			img-top-class="card-img-top-items mx-auto d-block"
			img-top-src="{{ asset(str_replace('public/','storage/',$collection->img_src)) }}">
				<template slot="body">
					<div class="text-center">
						<h6>{!! ($collection->featured) ? "<span class='badge badge-danger'>featured</span>" : '' !!}</h6>
						<h5>{{ $collection->name }}</h5>
						<a class="btn btn-primary" href="{{ route('collection.show',$collection->id) }}">View Collection</a>	
					</div>
					
				</template>
			</theme1-shop-card>
			@endforeach
		@endif
	</div>
</div>
@endsection
@section('modals')
@endsection
@section('variables')
@endsection