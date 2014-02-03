<div id="user-popup" class="popup-mini popup">
	<div class="close link"></div>
	<h2>Mon profil</h2>

	<div class="popup-content">
		<form id="profil-form">
			{{ Form::text('username',	'', array('placeholder' => 'Pseudo')) }}<br/>
			{{ Form::email('email',		'', array('placeholder' => 'Email')) }}<br/>
			{{ Form::text('birthday_at','', array('placeholder' => 'Date de naissance : 00/00/0000')) }}<br/>

			<input type="hidden" name="birthday_time"/>

			{{ Form::button('Modifier mon profil') }}<br/>

			<p>
				<span class="avatar-link link">Mon avatar</span>
				 | 
				<span class="password-link link">Mon mot de passe</span>
			</p>

			<p id="logout-link" class="error link">Me déconnecter</p>
			<p id="newsletter-link" class="link"></p>
			<p id="delete-link" class="link">Supprimer mon compte</p>
		</form>

		<form id="avatar-form" enctype="multipart/form-data">
			<div id="edit-avatar-content" class="preview-content">
				{{ Form::file('photo', array('accept' => 'image/png,image/jpg', 'size' => '1048576', 'data-preview' => 'edit-avatar-preview')) }}
				<img id="edit-avatar-preview" class="preview" alt="Avatar"/>
			</div>
			<br/>
			{{ Form::button('Modifier mon avatar') }}<br/>

			<p>
				<span class="profil-link link">Mon profil</span>
				 | 
				<span class="password-link link">Mon mot de passe</span>
			</p>
		</form>

		<form id="password-form">
			{{ Form::input('password', 'old_password-nocrypt',	'', array('placeholder' => 'Mon mot de passe')) }}<br/>
			{{ Form::input('password', 'password-nocrypt',		'', array('placeholder' => 'Mon nouveau mot de passe')) }}<br/>
			{{ Form::input('password', 'password-confirm',		'', array('placeholder' => 'Confirmation de mon nouveau mot de passe')) }}<br/>

			<input type="hidden" name="old_password"/>
			<input type="hidden" name="password"/>

			{{ Form::button('Modifier mon mot de passe') }}<br/>

			<p>
				<span class="profil-link link">Mon profil</span>
				 | 
				<span class="avatar-link link">Mon avatar</span>
			</p>
		</form>
	</div>
</div>

<script type="text/javascript">
$(function()
{
	$('#profil-form button').click(function()
	{
		User.setFormId('profil-form');

		if (User.checkUpdateForm()) User.update();
	});

	$('#avatar-form button').click(function()
	{
		User.setFormId('avatar-form');

		if (User.checkAvatarForm()) User.avatar();
	});

	$('#password-form button').click(function()
	{
		User.setFormId('password-form');

		if (User.checkPasswordForm()) User.password();
	});

	$('#newsletter-link').click(function()
	{
		User.setLinkId('newsletter-link');

		User.newsletter();
	});

	$('#logout-link').click(function()
	{
		User.setLinkId('logout-link');

		User.logout();
	});

	$('#delete-link').click(function()
	{
		User.setLinkId('delete-link');

		User.delete();
	});

	/**
	 * Switch form
	 */

	$('.profil-link').click(function()
	{
		showUserPopupForm('profil-form');

		$('#user-popup h2').html('Mon profil');
	});

	$('.avatar-link').click(function()
	{
		showUserPopupForm('avatar-form');

		$('#user-popup h2').html('Mon avatar');
	});

	$('.password-link').click(function()
	{
		showUserPopupForm('password-form');

		$('#user-popup h2').html('Mon mot de passe');
	});

	function showUserPopupForm(form_id)
	{
		var is_complete = false;

		$('#user-popup form').fadeOut(function()
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