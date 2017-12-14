@extends($layout)
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.0/sweetalert2.min.css">
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.0/sweetalert2.min.js"></script>
@include('Alerts::alerts')
<script type="text/javascript" src="{{ mix('/js/views/home/pages.js') }}"></script>
@endsection
@section('header')

@endsection


@section('content')

<div class="container">
 <div class="row justify-content-center">
    <div class="col-md-12 col-lg-8">
        <div class="form-area">  
                        <h3 style="margin-bottom: 25px; text-align: center;">Contact Form</h3>
    {!! Form::open(['method'=>'post','route'=>['contact.store']]) !!}
        <hr>
                <div class="content">
                    <!-- Name -->
                    <bootstrap-input class="form-group-no-border {{ $errors->has('name') ? ' has-danger' : '' }}" 
                        b-placeholder="Name"
                        b-name="name"
                        b-type="text"
                        b-value="{{ old('name') }}"
                        b-err="{{ $errors->has('name') }}"
                        b-error="{{ $errors->first('name') }}"
                        required>
                    </bootstrap-input>


                    <!-- email -->
                    <bootstrap-input class="form-group-no-border {{ $errors->has('email') ? ' has-danger' : '' }}" 
                        b-placeholder="E-mail Address"
                        b-name="email"
                        b-type="text"
                        b-value="{{ old('email') }}"
                        b-err="{{ $errors->has('email') }}"
                        b-error="{{ $errors->first('email') }}"
                        >
                    </bootstrap-input>

                    <!-- Phone Number -->
                    <bootstrap-input class="form-group-no-border {{ $errors->has('phone') ? ' has-danger' : '' }}" 
                        b-placeholder="Phone Number"
                        b-name="phone"
                        b-type="text"
                        b-value="{{ old('phone') }}"
                        b-err="{{ $errors->has('phone') }}"
                        b-error="{{ $errors->first('phone') }}"
                        >
                    </bootstrap-input>

                    <!-- Subject -->

                   <bootstrap-control class="form-group-no-border" b-name="subject">
                        <template slot="control">
                            <select class="form-control" name="subject">
                                    <option value="Custom Order">Custom Order</option>
                                    <option value="New Order">New Order</option>
                                    <option value="Current Order">Current Order</option>
                                    <option value="Other">Other</option>
                            </select>
                         </template>
                     </bootstrap-control> 

              

                   

                    <!-- Description -->
                    <bootstrap-textarea class="form-group-no-border {{ $errors->has('message') ? ' has-danger' : '' }}" 
                        b-placeholder="Message"
                        b-name="message"
                        b-type="textarea"
                        b-value="{{ old('message') }}"
                        b-err="{{ $errors->has('message') }}"
                        b-error="{{ $errors->first('message') }}"
                        >
                    </bootstrap-textarea>


                </div>
                <div class="clearfix">
                <button type="submit" class ="btn btn-warning pull-right">Send</button>
                </div>
    {!! Form::close() !!}
      <hr>
    </div>
    </div>
  </div>

</div>

</div> 


{{--  Included Infinety Alerts/ Sweetalert2   --}}


@endsection

@section('modals')
@endsection