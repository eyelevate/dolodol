@extends('layouts.themes.backend.layout')
@section('styles')
@endsection
@section('scripts')
<script type="text/javascript" src="{{ mix('/js/views/inventory_items/create.js') }}"></script>

@endsection
@section('content')
<!-- Breadcrumb -->	
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventory</a></li>
    <li class="breadcrumb-item active">Create</li>
</ol>

<div class="container-fluid">
	{!! Form::open(['id'=>'item-form','method'=>'post','route'=>['inventory_item.store',$inventory->id],'enctype'=>'multipart/form-data','v-on:submit'=>'submitForm']) !!}

		<bootstrap-card use-header = "true" use-body="true" use-footer = "true">
			<template slot = "header"> Create An Inventory Item </template>
			<template slot = "body">
	            <div class="content">
	            	
	            	<!-- Name -->
	                <bootstrap-input class="form-group-no-border {{ $errors->has('name') ? ' has-danger' : '' }}" 
	                    use-label = "true"
	 					label = "Name"
	                    b-placeholder="Name"
	                    b-name="name"
	                    b-type="text"
	                    b-value="{{ old('name') }}"
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
	                    b-value="{{ old('desc') }}"
	                    b-err="{{ $errors->has('desc') }}"
	                    b-error="{{ $errors->first('desc') }}"
	                    >
	                </bootstrap-textarea>

	                <!-- Subtotal -->
	                <bootstrap-input class="form-group-no-border {{ $errors->has('subtotal') ? ' has-danger' : '' }}" 
	                    use-label = "true"
	 					label = "Subtotal (Base Price)"
	                    b-placeholder="0.00"
	                    b-name="subtotal"
	                    b-type="text"
	                    b-value="{{ old('subtotal') }}"
	                    b-err="{{ $errors->has('subtotal') }}"
	                    b-error="{{ $errors->first('subtotal') }}"
	                    >
	                </bootstrap-input>
	                <hr/>
	                <bootstrap-control
	                	use-label="true"
	                	label="Sizes Selectable?">
	                	<template slot="control">
	                		<div class="row-fluid">
					            <label class="switch switch-text switch-success" >
					                <input id="switch-input-on" name="sizes" type="checkbox" class="switch-input" @click="updateSizes"/>
					                <span class="switch-label" data-on="Yes" data-off="No" ></span>
					                <span class="switch-handle"></span>
					            </label>    
					        </div>
	                	</template>
	                </bootstrap-control>
	                <div v-if="sizes">
	                	<table class="table table-bordered table-responsive">
	                		<thead>
	                			<tr>
	                				<th>Size</th>
	                				<th style="width:125px">Length (cm)</th>
	                				<th style="width:125px">Height (cm)</th>
	                				<th style="width:125px">Width (cm)</th>
	                				<th style="width:125px">+ subtotal</th>
	                				<th style="width:125px">Action</th>
	                			</tr>
	                		</thead>
	                		<tbody>
	                			<tr v-for="size, k in sizeList" :class="size.status ? '' : 'table-active'">
	                				<td>
	                					<input :name="'sizelist['+k+'][name]'" v-model="size.name" class="form-control" v-if="size.status"/>
	                					<input :name="'sizelist['+k+'][name]'" v-model="size.name" class="form-control" v-else disabled/>
	                				</td>
	                				<td style="width:125px">
	                					<input :name="'sizelist['+k+'][x_cm]'" v-model="size.x_cm" class="form-control" v-if="size.status"/>
	                					<input :name="'sizelist['+k+'][x_cm]'" v-model="size.x_cm" class="form-control" v-else disabled/>
	                				</td>
	                				<td style="width:125px">
	                					<input :name="'sizelist['+k+'][y_cm]'" v-model="size.y_cm" class="form-control" v-if="size.status" />
	                					<input :name="'sizelist['+k+'][y_cm]'" v-model="size.y_cm" class="form-control" v-else disabled/>
	                				</td>
	                				<td style="width:125px">
	                					<input :name="'sizelist['+k+'][z_cm]'" v-model="size.z_cm" class="form-control" v-if="size.status"/>
	                					<input :name="'sizelist['+k+'][z_cm]'" v-model="size.z_cm" class="form-control" v-else disabled/>
	                				</td>
	                				<td style="width:125px">
	                					<input :name="'sizelist['+k+'][subtotal]'" v-model="size.subtotal" class="form-control" v-if="size.status"/>
	                					<input :name="'sizelist['+k+'][subtotal]'" v-model="size.subtotal" class="form-control" v-else disabled/>
	                				</td>
	                				<td style="width:125px">
	                					<label class="switch switch-text switch-primary">
										    <input :name="'sizelist['+k+'][status]'" type="checkbox" class="switch-input" checked @click="updateSizeRow(k)">
										    <span class="switch-label" data-on="On" data-off="Off"></span>
										    <span class="switch-handle"></span>
										</label>
	                				</td>
	                			</tr>
	                		</tbody>
	                	</table>
	                </div>
	        		<hr/>
	                <!-- Taxable -->

					<bootstrap-switch 
	                	switch-type=""
	                	switch-color="switch-success"
	                	use-label="true" 
	                	label="Taxable?" 
	                	input-name="taxable"
	                	input-checked="true">
	                </bootstrap-switch>

	                <hr/>
	                <!-- Featured -->

					<bootstrap-switch 
	                	switch-type=""
	                	switch-color="switch-success"
	                	use-label="true" 
	                	label="Featured?" 
	                	input-name="featured"
	                	input-checked="false">
	                </bootstrap-switch>
	                <hr/>
	                <!-- Active -->

					<bootstrap-switch 
	                	switch-type=""
	                	switch-color="switch-success"
	                	use-label="true" 
	                	label="Activate?" 
	                	input-name="active"
	                	input-checked="false">
	                </bootstrap-switch>

	                <hr/>

	                

	                <!-- Images -->
	                <bootstrap-control
	                	use-label="true"
	                	label="Image(s)"
	                    b-err="{{ $errors->has('img_src') }}"
	                    b-error="{{ $errors->first('img_src') }}">
	                	<template slot="control">
	                		<div class="card imagePreviewCard col-12"  style="padding-top:20px;">
	                			<div class="row-fluid">
	                				<div v-for="i,k in images">      				
		                				<div class="col-xs-12 col-sm-6 col-md-4 pull-left">
			                				<bootstrap-card
			                					class="image-divs"
			                					use-img-top="true"
			                					use-header="true"
			                					use-footer="true"
			                					:img-top-src="i.src"
			                					img-top-class="card-img-top-inventory"
			                				>
			                					<template slot="header">
			                						@{{ i.name }}
			                					</template>
			                					<template slot="footer">
			                						<button type="button" class="make-primary btn btn-primary" @click="primaryImage(k, $event)">Set Primary</button>
				                					<button type="button" class="btn btn-danger" @click="removeImage(k)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
				                					<input type="hidden" :name="i.primary_name" v-model="images[k]['primary']">	
			                					</template>
			                				</bootstrap-card>
		                				</div>
	                				</div>
	                			</div>

	                			
	                			<div id="image-parent" class="card-block">
	                				<input id="uploader" name="imgs[]" type="file" multiple class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
	                			</div>
	                		</div>
	                		
	                	</template>
	               	</bootstrap-control>
	               	<hr/>
	               	<!-- Videos -->
	               	<bootstrap-control
	                	use-label="true"
	                	label="Video"
	                    b-err="{{ $errors->has('video_src') }}"
	                    b-error="{{ $errors->first('video_src') }}">
	                	<template slot="control">
	                		<div class="card videoPreviewCard col-12"  style="padding-top:20px;">
	                			<div class="row-fluid">
	                				<div v-for="v,k in videos">      				
		                				<div class="col-xs-12 col-sm-6 col-md-4 pull-left">
			                				<bootstrap-card
			                					class="image-divs"
			                					use-body="true"
			                					use-header="true"
			                					use-footer="true"
			                				>
			                					<template slot="header">
			                						@{{ v.name }}
			                					</template>
			                					<template slot="body">
			                						<video style="width:100%;">
			                							<source :src="v.src" :type="v.type">
			                						</video>
			                					</template>
			                					<template slot="footer">
				                					<button type="button" class="btn btn-danger" @click="removeVideo(k)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
				                					<input type="hidden" :name="v.name" v-model="videos[k]['src']">	
			                					</template>
			                				</bootstrap-card>
		                				</div>
	                				</div>
	                			</div>

	                			
	                			<div id="video-parent" class="card-block">
	                				<input id="video-uploader" name="videos[]" type="file" multiple class="form-control-file" aria-describedby="fileHelp" @change="setVideos($event)" >
	                			</div>
	                		</div>
	                		
	                	</template>
	               	</bootstrap-control>
		        </div>
			</template>

			<template slot = "footer">
				<a href="{{ route('inventory.index') }}" class="btn btn-secondary">Back</a>
				<button type="button" class = "btn btn-primary" @click="submitForm">Save</button>
			</template>
		</bootstrap-card>
		
		{!! Form::close() !!}
</div>
@endsection

@section('modals')

<bootstrap-modal id="send-form-modal" b-size="modal-lg">
	<template slot="header">Please Wait!</template>
	<template slot="body">
		<p class="text-center">Loading Form Images / Videos... This can take up to 20 seconds depending on the size of the resource.</p>
		<h1 class="text-center"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i><h1>
	</template>
	<template slot="footer"></template>
</bootstrap-modal>
@endsection

@section('variables')
<div id="variable-root"></div>
@endsection
