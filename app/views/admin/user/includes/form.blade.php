<form method="post" action="{{ route('admin_user_edit_validation', array('id' => $user->id)) }}" accept-charset="UTF-8" class="form-horizontal">

	<div class="form-group">
		{{ Form::label('photo', 'Avatar', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">{{ HTML::image($user->photo->url, $user->username, array('width' => '100px')) }}</div>
	</div>

	<div class="form-group">
		{{ Form::label('reference', 'Référence', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::text('reference', $user->reference, array('class' => 'form-control', 'disabled' => true)) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('username', 'Pseudo', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::text('username', $user->username, array('class' => 'form-control', 'placeholder' => 'Pseudo', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Email', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::email('email', $user->email, array('class' => 'form-control', 'placeholder' => 'Email', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('birthday_at', 'Date de naissance', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::text('birthday_at', date('d/m/Y', strtotime($user->birthday_at)), array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => 'Date de naissance', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-4"></div>
		<div class="col-lg-8">
			{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Mettre à jour l\'utilisateur', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
		</div>
	</div>

{{ Form::close() }}