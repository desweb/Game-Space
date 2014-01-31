<div id="auth-popup" class="popup-mini popup">
	<div class="close link"></div>
	<h2>Connexion</h2>

	<div class="popup-content">
		<div id="connexion-form" class="form">
			{{ Form::email('connexion-email', Input::old('connexion-email'), array('placeholder' => 'Email')) }}
			{{ Form::input('password', 'connexion-password', '', array('placeholder' => 'Mot de passe')) }}
			{{ Form::button('Me connecter') }}

			<p>
				<span class="registration-link link">M'inscrire</span>
				 | 
				<span class="password-lost-link link">Mot de passe perdu ?</span>
			</p>
		</div>

		<div id="registration-form" class="form">
			<div id="registration-avatar-content" class="preview-content">
				{{ Form::file('registration-avatar', array('accept' => 'image/png,image/jpg', 'size' => '1048576', 'data-preview' => 'registration-avatar-preview')) }}
				<img id="registration-avatar-preview" class="preview" alt="Avatar"/>
			</div>

			{{ Form::text('registration-username', Input::old('registration-username'), array('placeholder' => 'Pseudo')) }}
			{{ Form::email('registration-email', Input::old('registration-email'), array('placeholder' => 'Email')) }}
			{{ Form::input('password', 'registration-password', '', array('placeholder' => 'Mot de passe')) }}
			{{ Form::input('password', 'registration-password-confirm', '', array('placeholder' => 'Confirmation du mot de passe')) }}
			{{ Form::button('M\'inscrire') }}

			<p>
				<span class="connexion-link link">Me connecter</span>
				 | 
				<span class="password-lost-link link">Mot de passe perdu ?</span>
			</p>
		</div>

		<div id="password-lost-form" class="form">
			{{ Form::email('password-lost-email', Input::old('password-lost-email'), array('placeholder' => 'Email')) }}
			{{ Form::button('Réinitialiser mon mot de passe') }}

			<p>
				<span class="connexion-link link">Me connecter</span>
				 | 
				<span class="registration-link link">M'inscrire</span>
			</p>
		</div>
	</div>
</div>

<script type="text/javascript">
$(function()
{
	$('.connexion-link').click(function()
	{
		showAuthPopupForm('connexion-form');
	});

	$('.registration-link').click(function()
	{
		showAuthPopupForm('registration-form');
	});

	$('.password-lost-link').click(function()
	{
		showAuthPopupForm('password-lost-form');
	});

	function showAuthPopupForm(form_id)
	{
		var is_complete = false;

		$('#auth-popup .form').fadeOut(function()
		{
			if (is_complete) return false;

			is_complete = true;

			setTimeout(function()
			{
				$('#' + form_id).fadeIn();
			}, 500);
		});
	}
});
</script>