<form method="post" action="{{ route('admin_witness_edit_validation', array('id' => $witness->id)) }}" accept-charset="UTF-8" class="form-horizontal">

	<div class="form-group">
		{{ Form::label('user', 'Propriétaire', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::text('user', $witness->user->username, array('class' => 'form-control', 'disabled' => true)) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('game', 'Jeu', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::text('user', $witness->game->title, array('class' => 'form-control', 'disabled' => true)) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('star', 'Note', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8"><p class="text-form-control">{{ $witness->displayStar() }}</p></div>
	</div>

	<div class="form-group">
		{{ Form::label('message', 'Description du témoignage', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::textarea('message', $witness->message, array('class' => 'form-control', 'placeholder' => 'Description du témoignage', 'required' => true)) }}
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-4"></div>
		<div class="col-lg-8">
			{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Mettre à jour le témoignage', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
		</div>
	</div>

{{ Form::close() }}