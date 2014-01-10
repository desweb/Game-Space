<form method="post" action="{{ route('admin_profile_edit_password_validation') }}" class="form-horizontal">

	<div class="form-group">
		{{ Form::label('old_password', 'Mot de passe actuel', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			<input type="password" name="old_password" placeholder="Mot de passe actuel" class="form-control" required/>
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('password', 'Nouveu mot de passe', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			<input type="password" name="password" placeholder="Nouveu mot de passe" class="form-control" required/>
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('password_confirm', 'Confirmation du nouveau mot de passe', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			<input type="password" name="password_confirm" placeholder="Confirmation du nouveau mot de passe" class="form-control" required/>
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-4"></div>
		<div class="col-lg-8">
			{{ Form::button('Modifier mon mot de passe', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
		</div>
	</div>

{{ Form::close() }}