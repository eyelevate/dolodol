@extends($layout)
@section('scripts')
@endsection
@section('header')
@endsection


@section('content')
{{-- 
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-12 col-lg-8">
        <div class="form-area">  
            <form role="form">
                        <h3 style="margin-bottom: 25px; text-align: center;">Contact Form</h3>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required>
                        </div>
            
                        <div class="form-group">
                                <select class="form-control" id="subjectSelect" name="subject" placeholder="Subject" required>
                                <option>Custom Order</option>
                                <option>New Order</option>
                                <option>Current Order</option>
                                <option>Other</option>
                                </select>
                        </div>
                        <div class="form-group">
                        <textarea class="form-control" type="textarea" id="message" placeholder="Message" maxlength="800" rows="7"></textarea>                
                        </div>


                <a href="{{ route('contact.create') }}" class="btn btn-warning pull-right">Submit</a>
            <button type="button" id="submit" name="submit" class="btn btn-warning pull-right">Submit Form</button> 
            </form>
        </div>
    </div>
    </div>
<br>
<hr>

</div> --}}


@endsection

@section('modals')
@endsection