@extends('layouts.themes.backend.layout')

@section('scripts')
<script type="text/javascript" src="{{ mix('/js/views/admins/index.js') }}"></script>
@endsection


@section('content')
<!-- Breadcrumb -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Sizes</li>
</ol>
<div class="container-fluid">
	
	<bootstrap-card use-header="true" use-body="true" use-footer="true">
		
		<template slot="header">Sizes </template>
		
		<template slot="body">
			<div class="table-responsive">
				<bootstrap-table
					:columns="{{ $columns }}"
					:rows="{{ $rows->toJson() }}"
					:paginate="true"
					:global-search="true"
					:line-numbers="true"/>
				</bootstrap-table>
		    </div>
		</template>
 		
		<template slot="footer">
			<a href="{{ route('size.create') }}" class="btn btn-primary">Add Size</a>
			
		</template>

	</bootstrap-card>
	
</div>
@endsection


@section('modals')
@if (count($rows) > 0)
	@foreach($rows as $row)
		<bootstrap-modal id="viewModal-{{ $row->id }}" b-size="modal-lg">
			<template slot="header">View Stone Size - {{ $row->size }}</template>
			<template slot="body">
				<!-- Size -->
				<bootstrap-readonly
					use-input="true"
					b-value="{{ $row->size }}"
					use-label="true"
					b-label="Size">	
				</bootstrap-readonly>

				<!-- Name -->
				<bootstrap-readonly
					use-textarea="true"
					b-value="{{ $row->name }}"
					use-label="true"
					b-label="Name">
				</bootstrap-readonly>
			</template>
			
			<template slot="footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal-{{ $row->id }}">Delete</button>	
				<a href="{{ route('size.edit',$row->id) }}" class="btn btn-primary">Edit</a>
			</template>
		</bootstrap-modal>

		{!! Form::open(['method'=>'delete','route'=>['size.destroy',$row->id]]) !!}
		<bootstrap-modal id="deleteModal-{{ $row->id }}">
			<template slot="header">Delete Confirmation</template>
			<template slot="body">
				Are you sure you wish to delete {{ $row->name }}?
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