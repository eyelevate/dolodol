@extends('layouts.themes.backend.layout')

@section('scripts')
<script type="text/javascript" src="{{ mix('/js/views/admins/index.js') }}"></script>
@endsection

@section('content')
<!-- Breadcrumb -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Collections </li>
</ol>
<div class="container-fluid">
	
	<bootstrap-card use-header="true" use-body="true" use-footer="true">
		<template slot="header">Collection Search Results</template>
		<template slot="body">
			<div class="table-responsive">
				<bootstrap-table
					:columns="{{ $columns }}"
					:rows="{{ $rows }}"
					:paginate="true"
					:global-search="true"
					:line-numbers="true"/>
				</bootstrap-table>
		    </div>
		</template>

		<template slot="footer">
			<a href="{{ route('collection.create') }}" class="btn btn-primary">Add Collection</a>
		</template>
	</bootstrap-card>
	
</div>
@endsection

@section('modals')
@if (count($rows) > 0)
	@foreach($rows as $row)
		<bootstrap-modal id="viewModal-{{ $row->id }}" b-size="modal-lg">
			<template slot="header">View Collection - {{ $row->name }}</template>
			<template slot="body">
				<div class="card imagePreviewCard col-12" >
        			<img src="/{{ $row->img_src }}" class="card-img-top"/>
        			<div class="card-block">
        				<h4 class="card-title">{{ $row->name }}</h4>
					    <p class="card-text">{{ $row->desc }}</p>
					    <a href="{{ route('collection.set',$row->id) }}" class="btn btn-primary btn-block">Manage Collection Items</a>
        			</div>
        		</div>		

				
			</template>
			<template slot="footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal-{{ $row->id }}">Delete</button>	
				<a href="{{ route('collection.edit',$row->id) }}" class="btn btn-primary">Edit</a>
			</template>
		</bootstrap-modal>

		{!! Form::open(['method'=>'delete','route'=>['collection.destroy',$row->id]]) !!}
		
		<bootstrap-modal id="deleteModal-{{ $row->id }}">
			<template slot="header">Delete Confirmation</template>
			<template slot="body">
				Are you sure you wish to delete {{ $row->full_name }}?
			</template>
			<template slot="footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger">Delete</button>	
			</template>
		</bootstrap-modal>
		{!! Form::close() !!}
	@endforeach
@endif
@endsection