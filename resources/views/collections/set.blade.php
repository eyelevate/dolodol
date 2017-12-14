@extends('layouts.themes.backend.layout')

@section('scripts')
<script type="text/javascript" src="{{ mix('/js/views/collections/set.js') }}"></script>
@endsection

@section('content')
<!-- Breadcrumb -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('collection.index') }}">Collections</a></li>
    <li class="breadcrumb-item active">Set Items </li>
</ol>
<div class="container-fluid">

	<bootstrap-jumbotron use-header="true" header-content="{{ $collection->name }}" header-class="display-3">
		<template slot="body">
			{{-- <h1 class="display-3">{{ $collection->name }}</h1> --}}
			<p class="lead">{{ $collection->desc }}</p>
			<hr class="my-4">
			<p>Select from the following inventory groups below to display corresponding inventory item content.</p>
			<bootstrap-select>
				<template slot="select">
					{{ Form::select('inventory',$inventory_select,'',['class'=>'form-control','v-on:change'=>'setInventory($event)']) }}
				</template>
			</bootstrap-select>
		</template>
	</bootstrap-jumbotron>
	<div class="row" v-for="inventory in inventories">
		<div v-if="inventory.id == inventoryId"  class="col-12">
			<div v-for="inventory_item in inventory.inventory_items">

				<div v-if="inventory_item.collection_set" class="col-xs-12 col-sm-6 col-md-4 col-lg-3 pull-left">
					<bootstrap-card				
						class="card-inverse bg-success "
						use-header="true"
						use-img-top="true"
						:img-top-src="inventory_item.primary_src"
						use-body="true"
						use-footer="true"
					>
						<template slot="header">@{{ inventory_item.name }}</template>
						<template slot="body">
							<p>@{{ inventory_item.desc }}</p>
						</template>
						<template slot="footer">
							<div class="form-button-group">
								<button class="remove-set btn btn-sm btn-block btn-danger" type="button" @click="remove(inventory_item.id,collectionId,$event)">Remove</button>
							</div>
						</template>
					</bootstrap-card>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 pull-left" v-else>
					<bootstrap-card				
						use-header="true"
						use-img-top="true"
						:img-top-src="inventory_item.primary_src"
						use-body="true"
						use-footer="true"
					>
						<template slot="header">@{{ inventory_item.name }}</template>
						<template slot="body">
							<p>@{{ inventory_item.desc }}</p>
						</template>
						<template slot="footer">
							<div class="form-button-group">
								<button class="add-set btn btn-sm btn-block btn-success" type="button" @click="add(inventory_item.id,collectionId,$event)">Add</button>
							</div>
						</template>
					</bootstrap-card>
				</div>

			</div>
		</div>
	</div>
	
</div>
@endsection

@section('modals')

@endsection
@section('variables')
<input type="hidden" id="inventories" value="{{ json_encode($inventories) }}">
<input type="hidden" id="collection-id" value="{{ $collection->id }}">
@endsection