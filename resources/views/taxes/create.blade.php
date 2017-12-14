
@extends('layouts.themes.backend.layout')

@section('styles')
@endsection

@section('scripts')
<script type="text/javascript" src="{{ mix('js/views/stone_sizes/create.js') }}"></script>
@endsection

@section('content')
<!-- Breadcrumb -->	
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('tax.index') }}">Taxes</a></li>
    <li class="breadcrumb-item active">Create</li>
</ol>

<div class="container-fluid">
	{!! Form::open(['method'=>'post','route'=>['tax.store']]) !!}

		<bootstrap-card use-header = "true" use-body="true" use-footer = "true">
			<template slot = "header"> Create Tax </template>
			<template slot = "body">
	            <div class="content">

					<!-- Rate -->
	                <bootstrap-input class="form-group-no-border {{ $errors->has('rate') ? ' has-danger' : '' }}" 
	                    use-label = "true"
	 					label = "Rate (Decimal Value e.g 8% = 0.08)"
	                    b-placeholder="0.0825"
	                    b-name="rate"
	                    b-type="text"
	                    b-value="{{ old('rate') }}"
	                    b-err="{{ $errors->has('rate') }}"
	                    b-error="{{ $errors->first('rate') }}"
	                    >
	                </bootstrap-input>
		        </div>
			</template>

			<template slot = "footer">
				<a href="{{ route('tax.index') }}" class="btn btn-secondary">Back</a>
				<button type="submit" class = "btn btn-primary">Save</button>
			</template>
		</bootstrap-card>
	{!! Form::close() !!}
</div>
@endsection


