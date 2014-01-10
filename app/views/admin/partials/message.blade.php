@if (Session::has('message_success'))
	<div class="alert alert-success">
		{{ Session::get('message_success') }}
	</div>
@endif

@if (Session::has('message_info'))
	<div class="alert alert-info">
		{{ Session::get('message_info') }}
	</div>
@endif

@if (Session::has('message_warning'))
	<div class="alert">
		{{ Session::get('message_warning') }}
	</div>
@endif

@if (Session::has('message_error'))
	<div class="alert alert-danger">
		{{ Session::get('message_error') }}
	</div>
@endif

@if ($errors->count())
	@foreach ($errors->all() as $error)
		<div class="alert alert-danger">
			{{ $error }}
		</div>
	@endforeach
@endif