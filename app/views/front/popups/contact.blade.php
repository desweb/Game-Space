<div id="contact-popup" class="popup-mini popup">
	<div class="close link"></div>
	<h2>Contact</h2>

	<div class="popup-content">
		{{ Form::text('contact-username', Input::old('contact-username'), array('placeholder' => 'Prénom Nom')) }}
		{{ Form::email('contact-email', Input::old('contact-email'), array('placeholder' => 'Email')) }}

		<div class="select-style">
			{{ Form::select('contact-object', Contact::objects()) }}
		</div>

		{{ Form::textarea('contact-message', Input::old('contact-message'), array('placeholder' => 'Mon message')) }}
		{{ Form::button('Envoyer') }}
	</div>
</div>