<form method="post" action="{{ isset($administrator)? route('admin_administrator_edit_validation', array('id' => $administrator->id)): route('admin_administrator_add_validation') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal">

	@if (isset($administrator))
		<div class="form-group">
			{{ Form::label('photo', 'Avatar', array('class' => 'control-label col-lg-4')) }}
			<div class="col-lg-8">{{ HTML::image($administrator->photo->url, $administrator->username, array('width' => '100px')) }}</div>
		</div>

		<div class="form-group">
			{{ Form::label('reference', 'Référence', array('class' => 'control-label col-lg-4')) }}
			<div class="col-lg-8">
				{{ Form::text('reference', $administrator->reference, array('class' => 'form-control', 'disabled' => true)) }}
			</div>
		</div>
	@else
		<div class="form-group">
			{{ Form::label('photo', 'Avatar', array('class' => 'control-label col-lg-4')) }}
			<div class="col-lg-8">
				{{ Form::file('photo', array('class' => 'form-control', 'accept' => 'image/png,image/jpg', 'size' => 1048576, 'required' => true)) }}
			</div>
		</div>
	@endif

	<div class="form-group">
		{{ Form::label('username', 'Pseudo', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::text('username', isset($administrator)? $administrator->username: Input::old('username'), array('class' => 'form-control', 'placeholder' => 'Pseudo', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Email', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::email('email', isset($administrator)? $administrator->email: Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Email', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('birthday_at', 'Date de naissance', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::text('birthday_at', isset($administrator)? date('d/m/Y', strtotime($administrator->birthday_at)): Input::old('birthday_at'), array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => 'Date de naissance', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-4"></div>
		<div class="col-lg-8">
			@if (isset($administrator))
				{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Mettre à jour l\'administrateur', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
			@else
				{{ Form::button('<i class="glyphicon glyphicon-plus"></i> Créer l\'administrateur', array('type' => 'submit', 'class' => 'btn btn-success')) }}
			@endif
		</div>
	</div>

{{ Form::close() }}