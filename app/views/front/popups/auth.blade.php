<div id="auth-popup" class="popup-mini popup">
	<div class="close link"></div>
	<h2>Connexion</h2>

	<div class="popup-content">
		<form id="connexion-form">
			{{ Form::email('email', '', array('placeholder' => 'Email')) }}<br/>
			{{ Form::input('password', 'password-nocrypt', '', array('placeholder' => 'Mot de passe')) }}<br/>

			<input type="hidden" name="password"/>

			{{ Form::button('Me connecter') }}<br/>

			<p id="facebook-link" class="link" onclick="fbLogin();">Connexion Facebook</p>

			<p>
				<span class="registration-link link">M'inscrire</span>
				 | 
				<span class="password-lost-link link">Mot de passe perdu ?</span>
			</p>
		</form>

		<form id="registration-form" enctype="multipart/form-data">
			<div id="registration-avatar-content" class="preview-content">
				{{ Form::file('photo', array('accept' => 'image/png,image/jpg', 'size' => '1048576', 'data-preview' => 'registration-avatar-preview')) }}
				<img id="registration-avatar-preview" class="preview" alt="Avatar"/>
			</div>
			<br/>
			{{ Form::text('username',	'', array('placeholder' => 'Pseudo')) }}<br/>
			{{ Form::email('email',		'', array('placeholder' => 'Email')) }}<br/>
			{{ Form::text('birthday_at','', array('placeholder' => 'Date de naissance : 00/00/0000')) }}<br/>
			{{ Form::input('password', 'password-nocrypt', '', array('placeholder' => 'Mot de passe')) }}<br/>
			{{ Form::input('password', 'password-confirm', '', array('placeholder' => 'Confirmation du mot de passe')) }}<br/>

			<input type="hidden" name="birthday_time"/>
			<input type="hidden" name="password"/>
			<input type="hidden" name="hash"/>
			<input type="hidden" name="time"/>

			{{ Form::button('M\'inscrire') }}<br/>

			<p>
				<span class="connexion-link link">Me connecter</span>
				 | 
				<span class="password-lost-link link">Mot de passe perdu ?</span>
			</p>
		</form>

		<form id="password-lost-form">
			{{ Form::email('email', '', array('placeholder' => 'Email')) }}<br/>
			{{ Form::button('Réinitialiser mon mot de passe') }}<br/>

			<p>
				<span class="connexion-link link">Me connecter</span>
				 | 
				<span class="registration-link link">M'inscrire</span>
			</p>
		</form>
	</div>
</div>

<script type="text/javascript">
$(function()
{
	$('#connexion-form button').click(function()
	{
		User.setFormId('connexion-form');

		if (User.checkConnexionForm()) User.login();
	});

	$('#registration-form button').click(function()
	{
		User.setFormId('registration-form');

		if (User.checkRegistrationForm()) User.registration();
	});

	$('#password-lost-form button').click(function()
	{
		User.setFormId('password-lost-form');

		if (User.checkPasswordLostForm()) User.passwordLost();
	});

	/**
	 * Switch form
	 */

	$('.connexion-link').click(function()
	{
		showAuthPopupForm('connexion-form');

		$('#auth-popup h2').html('Connexion');
	});

	$('.registration-link').click(function()
	{
		showAuthPopupForm('registration-form');

		$('#auth-popup h2').html('Inscription');
	});

	$('.password-lost-link').click(function()
	{
		showAuthPopupForm('password-lost-form');

		$('#auth-popup h2').html('Mot de passe perdu');
	});

	function showAuthPopupForm(form_id)
	{
		var is_complete = false;

		$('#auth-popup form').fadeOut(function()
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

<div id="fb-root"></div>

<script type="text/javascript">
	window.fbAsyncInit = function()
	{
		FB.init({
			appId		: '{{ Config::get('facebook_app_id') }}',
			channelUrl	: '{{ Config::get('facebook_channel_url') }}',
			status		: true,
			cookie		: true,
			xfbml		: true
		});
	};

	function fbLogin()
	{
		FB.login(function(response)
		{
			if (!response.authResponse)
			{
				Console.info('User cancelled login or did not fully authorize.');
				return false;
			}

			FB.api('/me', function(response)
			{
				User.facebook(response);
			});
		},
		{
			scope : 'publish_stream,email,user_birthday'
		});
	}

	(function(d)
	{
		var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/fr_FR/all.js";
		ref.parentNode.insertBefore(js, ref);
	}(document));
</script>