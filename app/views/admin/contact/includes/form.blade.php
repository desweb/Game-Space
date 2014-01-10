<form method="post" action="{{ route('admin_contact_answer_validation', array('id' => $contact->id)) }}" accept-charset="UTF-8" class="form-horizontal">

	<div class="form-group">
		{{ Form::label('username', 'Expéditeur', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8"><p>{{ $contact->username }}</p></div>
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Email', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8"><p>{{ $contact->email }}</p></div>
	</div>

	<div class="form-group">
		{{ Form::label('object', 'Objet', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8"><p>{{ $contact->getObject() }}</p></div>
	</div>

	<div class="form-group">
		{{ Form::label('message', 'Message', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8"><p>{{ $contact->message }}</p></div>
	</div>

	<div class="form-group">
		{{ Form::label('answer', 'Réponse', array('class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			<p>Bonjour {{ $contact->username }},</p>
			<br/>
			{{ Form::textarea('answer', '', array('class' => 'form-control', 'placeholder' => 'Réponse du message', 'required' => true)) }}
			<br/>
			<p>L'équipe GameSpace</p>
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-4"></div>
		<div class="col-lg-8">
			{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Répondre au message', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
		</div>
	</div>

{{ Form::close() }}