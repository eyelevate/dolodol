@extends('layouts.themes.theme2.layout')
@section('scripts')
<script type="text/javascript" src="{{ mix('/js/views/home/index.js') }}"></script>
@endsection
@section('header')

@endsection

@section('content')
<div class="container">
	<div class="row" style="">
	@if(count($featured_items) > 0)
		@foreach($featured_items as $fi)

		<bootstrap-featured-ii 
			class="col-6 col-sm-4 col-md-3 col-lg-2"
			use-header = "false"
{{-- 			title="{{ $fi->name }}" --}}
			{{-- footer="{{ $fi->subtotal }}" --}}
			>
			<template slot="header">
				<img class="card-img-top lazy" src="{{ $fi->primary_img_src }}" >    
			</template>
		</bootstrap-featured-ii>	

		@endforeach
	@endif	
	</div>
	
</div>
@endsection

@section('modals')

@endsection
