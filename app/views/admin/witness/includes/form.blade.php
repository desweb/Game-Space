<form method="post" action="{{ route('admin_witness_edit_validation', array('id' => $witness->id)) }}" accept-charset="UTF-8" class="form-horizontal">

	<div class="form-group">
		{{ Form::label('user', 'Propriétaire', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8"><p>{{ $witness->displayUser() }}</p></div>
	</div>

	<div class="form-group">
		{{ Form::label('game', 'Jeu', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8"><p>{{ $witness->displayGame() }}</p></div>
	</div>

	<div class="form-group">
		{{ Form::label('star', 'Note', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8"><p>{{ $witness->displayStar() }}</p></div>
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