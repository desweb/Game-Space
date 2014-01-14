<form method="post" action="{{ isset($achievement)? route('admin_achievement_edit_validation', array('id' => $achievement->id)): route('admin_achievement_add_validation') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal">

	@if (isset($achievement))
		<div class="form-group">
			{{ Form::label('reference', 'Référence', array('class' => 'control-label col-lg-4')) }}
			<div class="col-lg-8">
				{{ Form::text('reference', $achievement->reference, array('class' => 'form-control', 'disabled' => true)) }}
			</div>
		</div>
	@else
		<div class="form-group">
			{{ Form::label('image', 'Image', array('class' => 'control-label col-lg-4')) }}
			<div class="col-lg-8">
				{{ Form::file('image', array('class' => 'form-control', 'accept' => 'image/png,image/jpg', 'size' => 1048576, 'required' => true)) }}
			</div>
		</div>
	@endif

	<div class="form-group">
		{{ Form::label('title', 'Titre', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::text('title', isset($achievement)? $achievement->title: Input::old('title'), array('class' => 'form-control', 'placeholder' => 'Titre', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('score', 'Score', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::input('number', 'score', isset($achievement)? $achievement->score: Input::old('score'), array('class' => 'form-control', 'placeholder' => 'Score', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('description', 'Description', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::textarea('description', isset($achievement)? $achievement->description: Input::old('description'), array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'Description', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-4"></div>
		<div class="col-lg-8">
			@if (isset($achievement))
				{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Mettre à jour le trophée', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
			@else
				{{ Form::button('<i class="glyphicon glyphicon-plus"></i> Créer le trophée', array('type' => 'submit', 'class' => 'btn btn-success')) }}
			@endif
		</div>
	</div>

{{ Form::close() }}