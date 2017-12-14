@extends($layout)
@section('scripts')
<script type="text/javascript" src="{{ mix('js/views/home/index.js') }}"></script>
@endsection
@section('styles')
@endsection
@section('content')
    <div class="row">
        <ul class="flex-row d-flex justify-content-center col-12">
            <h2>{{ $account->first_name}} {{ $account->last_name}}'s Account Information</h2>
        
      </ul>
    </div>

   <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <ul>
                <bootstrap-card use-header="false" use-body="true" use-footer="false">
                   {{--  <li class="col-12"><h5 class="text-center"><strong>Orders</strong></h5></li> --}}
                   {{--  <button type="button" class="btn btn-secondary btn-lg">Orders</button> --}}
		            <template slot="body">
					<a href="{{ route('customer.create') }}" class="btn btn-secondary btn-lg">Orders</a>
					</template>
				</bootstrap-card>
                </ul>
            </div>

            <div class="col-xs-12 col-sm-4 col-md-4">
                <ul>
                    {{-- <li class="col-12 text-center"><h5 class="text-center"><strong>Login & Security</strong></h5></li> --}}
               
	                <bootstrap-card use-header="false" use-body="true" use-footer="false">
			            <template slot="body">
						{{-- <a href="{{ route('customer.create') }}" class="btn btn-secondary btn-lg">Login & Security</a> --}}
						<button type="button" data-toggle="modal" data-target="#login" class="btn btn-secondary btn-lg" >Login & Security</button>
						</template>
					</bootstrap-card>
				</ul>
            </div>



            <div class="col-xs-12 col-sm-4 col-md-4">
                <ul>
                   {{--  <li class="col-12 text-center"><h5 class="text-center"><strong>Address</strong></h5></li> --}}
                    
                 <bootstrap-card use-header="false" use-body="true" use-footer="false">
		            <template slot="body">
					<a href="{{ route('customer.create') }}" class="btn btn-secondary btn-lg">Address</a>
					</template>
				</bootstrap-card>
                </ul>
            </div>
        </div>
        <br/>


        <bootstrap-modal id="login" b-size="modal-lg">
        	<template slot="header">Login & Security</template>

        	<template slot="body">
        		<!-- First Name -->
        		<div class="form-group">
        			<label>Name</label>
        			<div class="input-group" >
        				<input type="text" readonly="true" class="form-control" value="{{ $account->first_name }} {{ $account->last_name }}" style="background-color:#ffffff;"/></input>


        				<button type="button" data-toggle="modal" data-target="#nameEdit" class="btn btn-primary btn-sm">Edit</button>

        			</div>
        		</div>

        		<!-- Phone -->
        		<div class = "form-group">
        			<label>Phone</label>
        			<div class="input-group" >
        				<input type="text" readonly="true" class="form-control" value="{{ $account->phone }}" style="background-color:#ffffff;"></input>

        			</div>
        		</div>
        		<!-- Email -->
        		<div class = "form-group">
        			<label>Email</label>
        			<div class="input-group" >
        				<input type="text" readonly="true" class="form-control" value="{{ $account->email }}" style="background-color:#ffffff;"></input>

        			</div>
        		</div>
        	</template>

        	<template slot="footer">
        		<button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Done</button>
        	</template>
        </bootstrap-modal>


        <bootstrap-modal id="nameEdit" b-size="modal-lg">
        	<template slot="header">Edit User Name</template>

        	<template slot="body">

	            	<!--First Name-->
	                <bootstrap-input class="form-group-no-border {{ $errors->has('first_name') ? ' has-danger' : '' }}" 
	                    use-label = "true"
	 					label = "First Name"
	                    b-placeholder="First Name"
	                    b-name="first_name"
	                    b-type="text"
	                    b-value="{{ old('first_name') ? old('first_name') : $account->first_name }}"
	                    b-err="{{ $errors->has('first_name') }}"
	                    b-error="{{ $errors->first('first_name') }}"
	                    >
	                </bootstrap-input>

	            	<!--Last Name-->
	                <bootstrap-input class="form-group-no-border {{ $errors->has('last_name') ? ' has-danger' : '' }}" 
	                    use-label = "true"
	 					label = "Last Name"
	                    b-placeholder="Last Name"
	                    b-name="last_name"
	                    b-type="text"
	                    b-value="{{ old('last_name') ? old('last_name') : $account->last_name }}"
	                    b-err="{{ $errors->has('last_name') }}"
	                    b-error="{{ $errors->first('last_name') }}"
	                    >
	                </bootstrap-input>

        		</template>

			<template slot="footer">
        		<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Save</button>
        		<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        	</template>
        </bootstrap-modal>



@endsection
@section('modals')
@endsection
@section('variables')
@endsection