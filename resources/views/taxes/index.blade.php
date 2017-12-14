@extends('layouts.themes.backend.layout')

@section('scripts')
<script type="text/javascript" src="{{ mix('/js/views/admins/index.js') }}"></script>
@endsection


@section('content')
<!-- Breadcrumb -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Tax</li>
</ol>
<div class="container-fluid">
	
	<bootstrap-card use-header="true" use-body="true" use-footer="true">
		<template slot="header">Tax</template>
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
			<a href="{{ route('tax.create') }}" class="btn btn-primary">Set Tax Rate</a>
			{{-- <a href="{{ route('service_item.index') }}" class="btn btn-secondary">Manage Service Items</a> --}}
		</template>
	</bootstrap-card>
	
</div>
@endsection


@section('modals')

@endsection