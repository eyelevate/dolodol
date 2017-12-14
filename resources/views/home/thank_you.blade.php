@extends($layout)
@section('scripts')
<script type="text/javascript" src="{{ mix('js/views/home/index.js') }}"></script>
@endsection
@section('styles')
@endsection
@section('content')
<div class="container">
	<div class="jumbotron">
		<h1 class="display-3">Thank you!</h1>
		<p class="lead">We have sent an email with all of the important information regarding your current transaction with us.</p>
		<hr class="my-4">
		<p>If you have any questions or concerns please contact us by email at {{ $company->email }} or by phone at {{ $company->phone }}. </p>
		<p class="lead">
			<a class="btn btn-inverse btn-lg" href="{{ route('home') }}" role="button">Back Home</a>
		</p>	
	</div>	
</div>

@endsection
@section('modals')
@endsection
@section('variables')
@endsection