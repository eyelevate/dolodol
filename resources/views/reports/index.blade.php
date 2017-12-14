
@extends('layouts.themes.backend.layout')

@section('styles')
@endsection

@section('scripts')
<script type="text/javascript" src="{{ mix('js/views/admins/index.js') }}"></script>
@endsection

@section('content')
<!-- Breadcrumb -->	
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Reports</li>
    
</ol>
<div class="container-fluid">
	<div class="jumbotron">
		<h3 class="display-4">View Sales Reports</h3>
		<p class="lead">Use forms below to generate a report and chart of your sales data.</p>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div  class="col-xs-12 col-md-4 text-center">		

			<bootstrap-card 
				use-body="true">
				<template slot="body">
					<h6>Sales By Week</h6>
					<p>Displays yearly sales separated by weekly summaries.</p>
					<a href="{{ route('report.weeks') }}" class="btn btn-block btn-primary">Run Report</a>
				</template>
			</bootstrap-card>

		</div>
		<div  class="col-xs-12 col-md-4 text-center">		
		
			<bootstrap-card
				use-body="true">
				<template slot="body">
					<h6>Sales By Month</h6>
					<p>Displays yearly sales separated by monthly summaries.</p>
					<a href="{{ route('report.months') }}" class="btn btn-block btn-primary">Run Report</a>
					
				</template>
			</bootstrap-card>
		</div>
		<div  class="col-xs-12 col-md-4 text-center">		
			<bootstrap-card
				use-body="true">
				<template slot="body">
					<h6>Sales By Year</h6>
					<p>Displays yearly sales separated by yearly summaries.</p>
					<a href="{{ route('report.years') }}" class="btn btn-block btn-primary">Run Report</a>
				</template>
			</bootstrap-card>
		</div>
	</div>
	
</div>
@endsection
@section('modals')

@endsection
@section('variables')

@endsection

