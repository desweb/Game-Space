<div id="contact-popup" class="popup-mini popup">
	<div class="close link"></div>
	<h2>Contact</h2>

	<form id="contact-form" class="popup-content">
		{{ Form::text('username', '', array('placeholder' => 'Prénom Nom')) }}
		<br/>
		{{ Form::email('email', '', array('placeholder' => 'Email')) }}
		<br/>
		<div class="select-style">
			{{ Form::select('object', Contact::objects()) }}
		</div>
		<br/>
		{{ Form::textarea('message', '', array('placeholder' => 'Mon message')) }}
		<br/>
		{{ Form::button('Envoyer') }}
	</form>
</div>

<script type="text/javascript">
$(function()
{
	$('#contact-form button').click(function()
	{
		Contact.setFormId('contact-form');

		if (Contact.checkFields()) Contact.send();
	});
});
</script>