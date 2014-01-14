<form method="post" action="{{ isset($game)? route('admin_game_edit_validation', array('id' => $game->id)): route('admin_game_add_validation') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal">

	@if (isset($game))
		<div class="form-group">
			{{ Form::label('reference', 'Référence', array('class' => 'control-label col-lg-4')) }}
			<div class="col-lg-8">
				{{ Form::text('reference', $game->reference, array('class' => 'form-control', 'disabled' => true)) }}
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
			{{ Form::text('title', isset($game)? $game->title: Input::old('title'), array('class' => 'form-control', 'placeholder' => 'Titre', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('description', 'Phrase d\'accroche', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::textarea('description', isset($game)? $game->description: Input::old('description'), array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'Phrase d\'accroche', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-4"></div>
		<div class="col-lg-8">
			@if (isset($game))
				{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Mettre à jour le jeu', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
			@else
				{{ Form::button('<i class="glyphicon glyphicon-plus"></i> Créer le jeu', array('type' => 'submit', 'class' => 'btn btn-success')) }}
			@endif
		</div>
	</div>

{{ Form::close() }}