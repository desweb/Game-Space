<form method="post" action="{{ route('admin_profile_edit_validation') }}" class="form-horizontal">

	<div class="form-group">
		{{ Form::label('username', 'Pseudo', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::text('username', Auth::user()->username, array('class' => 'form-control', 'placeholder' => 'Pseudo', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Email', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::email('email', Auth::user()->email, array('class' => 'form-control', 'placeholder' => 'Email', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('birthday_at', 'Date de naissance', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::text('birthday_at', date('d/m/Y', strtotime(Auth::user()->birthday_at)), array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => 'Date de naissance', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-4"></div>
		<div class="col-lg-8">
			{{ Form::button('Mettre à jour mes informations', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
		</div>
	</div>

{{ Form::close() }}