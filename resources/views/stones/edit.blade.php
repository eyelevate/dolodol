
@extends('layouts.themes.backend.layout')

@section('styles')
@endsection

@section('scripts')
<script type="text/javascript" src="{{ mix('js/views/stones/edit.js') }}"></script>
@endsection

@section('content')
<!-- Breadcrumb -->	
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('stone.index') }}">Stone Type</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ol>

<div class="container-fluid">
	{!! Form::open(['method'=>'patch','route'=>['stone.update',$stone->id]]) !!}

		<bootstrap-card use-header = "true" use-body="true" use-footer = "true">
			<template slot = "header"> Edit A Stone Type </template>
			<template slot = "body">
	            <div class="content">
	            	
	            	<!-- Name -->
	                <bootstrap-input class="form-group-no-border {{ $errors->has('name') ? ' has-danger' : '' }}" 
	                    use-label = "true"
	 					label = "Name"
	                    b-placeholder="Name"
	                    b-name="name"
	                    b-type="text"
	                    b-value="{{ old('name') ? old('name') : $stone->name }}"
	                    b-err="{{ $errors->has('name') }}"
	                    b-error="{{ $errors->first('name') }}"
	                    >
	                </bootstrap-input>

					<!-- Description -->
	                <bootstrap-textarea class="form-group-no-border {{ $errors->has('desc') ? ' has-danger' : '' }}" 
	                    use-label = "true"
	 					label = "Description (optional)"
	                    b-placeholder="Description of stone type"
	                    b-name="desc"
	                    b-type="text"
	                    b-value="{{ old('desc') ? old('desc') : $stone->desc }}"
	                    b-err="{{ $errors->has('desc') }}"
	                    b-error="{{ $errors->first('desc') }}"
	                    >
	                </bootstrap-textarea>

					<!-- Price -->
	                <bootstrap-input class="form-group-no-border {{ $errors->has('price') ? ' has-danger' : '' }}" 
	                    use-label = "true"
	 					label = "Price"
	                    b-placeholder="0.00"
	                    b-name="price"
	                    b-type="text"
	                    b-value="{{ old('price') ? old('price') : $stone->price }}"
	                    b-err="{{ $errors->has('price') }}"
	                    b-error="{{ $errors->first('price') }}"
	                    >
	                </bootstrap-input>

	                <!-- Email Switch -->
	                <bootstrap-switch 
	                	@applied="onEmailChecked"
	                	id="emailSwitch"
	                	switch-type=""
	                	switch-color="switch-success"
	                	use-label="true" 
	                	label="Price By Email Request" 
	                	input-name="email"
	                	input-checked="{{ old('email') ? old('email') : ($stone->email) ? 'true' : 'false' }}">
	                </bootstrap-switch>

	                <!-- Stone Sizes -->
	                <hr/>
	                <div v-if="!checkEmail">
		                <label>Stone Sizes</label>
		                <div class="table-responsive">
		                	<table class="table table-condensed table-hover">
		                		<thead>
		                			<tr>
		                				<th>Size</th>
		                				<th>Name</th>
		                				<th>+ Price</th>
		                			</tr>
		                		</thead>
		                		<tbody>
		                		<tr v-for="s in sizes">
		                			<td>@{{ s.size }}</td>
		                			<td>@{{ s.name }}</td>
		                			<td width="200"><input :name="s.input_name" :value="s.price" class="form-control"/></td>
		                		</tr>

		                		</tbody>
		                	</table>
		                </div>	
	                </div>
	                
	            </div>
			</template>

			<template slot = "footer">
				<a href="{{ route('stone.index') }}" class="btn btn-secondary">Back</a>
				<button type="submit" class = "btn btn-primary">Update</button>
			</template>
		</bootstrap-card>
	{!! Form::close() !!}
</div>
@endsection
@section('variables')
<input id="sizes" type="hidden" value="{{ (count($sizes) > 0) ? json_encode($sizes) : json_encode([]) }}">
<input id="check-email" type="hidden" value="{{ $stone->email }}">
@endsection
