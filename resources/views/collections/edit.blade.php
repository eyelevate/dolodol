
@extends('layouts.themes.backend.layout')

@section('styles')
@endsection

@section('scripts')

<script type="text/javascript" src="{{ mix('/js/views/collections/create.js') }}"></script>
@endsection

@section('content')
<!-- Breadcrumb -->	
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('collection.index') }}">Collection List</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ol>

<div class="container-fluid">
	{!! Form::open(['method'=>'patch','route'=>['collection.update',$collection->id],'enctype'=>'multipart/form-data']) !!}

		<bootstrap-card use-header = "true" use-body="true" use-footer = "true">
			<template slot = "header"> Edit Collections </template>
			<template slot = "body">
	            <div class="content">
	            	
	            	<!-- Name -->
	                <bootstrap-input class="form-group-no-border {{ $errors->has('name') ? ' has-danger' : '' }}" 
	                    use-label = "true"
	 					label = "Name"
	                    b-placeholder="Name"
	                    b-name="name"
	                    b-type="text"
	                    b-value="{{ old('name') ? old('name') : $collection->name }}"
	                    b-err="{{ $errors->has('name') }}"
	                    b-error="{{ $errors->first('name') }}"
	                    >
	                </bootstrap-input>

					<!-- Description -->
	                <bootstrap-textarea class="form-group-no-border {{ $errors->has('desc') ? ' has-danger' : '' }}" 
	                    use-label = "true"
	 					label = "Description"
	                    b-placeholder="Description"
	                    b-name="desc"
	                    b-type="text"
	                    b-value="{{ old('desc') ? old('desc') : $collection->desc }}"
	                    b-err="{{ $errors->has('desc') }}"
	                    b-error="{{ $errors->first('desc') }}"
	                    >
	                </bootstrap-textarea>
	                <hr/>

	                <!-- Active -->

					<bootstrap-switch 
	                	switch-type=""
	                	switch-color="switch-success"
	                	use-label="true" 
	                	label="Activate?" 
	                	input-name="active"
	                	input-checked="{{ old('active') ? old('active') : ($collection->active) ? "true" : "false" }}">
	                </bootstrap-switch>
	                <hr/>
	                <!-- Featured -->

					<bootstrap-switch 
	                	switch-type=""
	                	switch-color="switch-success"
	                	use-label="true" 
	                	label="Featured?" 
	                	input-name="featured"
	                	input-checked="{{ old('featured') ? old('featured') : ($collection->featured) ? "true" : "false" }}">
	                </bootstrap-switch>
	                <hr/>
	                <!-- Image -->
	                <bootstrap-control
	                	use-label="true"
	                	label="Image"
	                    b-err="{{ $errors->has('img_src') }}"
	                    b-error="{{ $errors->first('img_src') }}">
	                	<template slot="control">
	                		<div class="card imagePreviewCard col-12" >
	                			<img id="preview" src="{{ asset(str_replace('public/','storage/',$collection->img_src)) }}" class="card-img-top">
	                			<div class="card-block">
	                				<input id="uploader" name="img" type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
	                				<input type="hidden"  value="{{ $collection->img_src }}" name="img_src"/>
	                				<input type="hidden"  value="{{ $collection->featured_src }}" name="featured_src"/>
	                			</div>
	                		</div>
	                		
	                	</template>
	               	</bootstrap-control>


		        </div>
			</template>

			<template slot = "footer">
				<a href="{{ route('collection.index') }}" class="btn btn-secondary">Back</a>
				<button type="submit" class = "btn btn-primary">Update</button>
			</template>
		</bootstrap-card>
		{!! Form::close() !!}
</div>
@endsection

