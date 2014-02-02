function User()
{
	var _is_loading = false;

	var _form_id;

	var _form_elements = {};
	var _button_element;

	var _access_token;
	var _access_token_expired_time;

	/**
	 * Functionnalities
	 */

	this.sendConnexion = function()
	{
		if (_is_loading) return;

		_is_loading = true;

		_button_element	= $('#' + _form_id + ' button');

		_button_element.html(Interface.getLoaderMini());

		API.post_auth(_form_id,
		{
			success : function(response)
			{
				if (response.error) return;

				Message.success('Connexion réussie.');
				Interface.hidePopup();

				_form_elements.email			.val('');
				_form_elements.password_nocrypt	.val('');
			},
			always : function()
			{
				_form_elements.password.val('');

				reinitForm();

				_is_loading = false;

				_button_element.html('Connexion');
			}
		});
	};

	this.sendFacebook = function(facebook_datas)
	{
		if (_is_loading) return;

		_is_loading = true;

		_button_element	= $('p#facebook-link');

		_button_element.html(Interface.getLoaderMini());

		API.post_authFacebook(facebook_datas,
		{
			success : function(response)
			{
				if (response.error) return;

				Message.success('Connexion réussie.');
				Interface.hidePopup();
			},
			always : function()
			{
				reinitForm();

				_is_loading = false;

				_button_element.html('Connexion Facebook');
			}
		});
	};

	this.sendRegistration = function()
	{
		if (_is_loading) return;

		_is_loading = true;

		_button_element	= $('#' + _form_id + ' button');

		_button_element.html(Interface.getLoaderMini());

		API.post_authAdd(_form_id,
		{
			success : function(response)
			{
				if (response.error) return;

				Message.success('Connexion réussie.');
				Interface.hidePopup();

				var preview_img = $('#' + _form_id + ' img.preview');
				preview_img.attr('src', '');
				preview_img.hide();

				_form_elements.photo		.val('');
				_form_elements.username		.val('');
				_form_elements.email		.val('');
				_form_elements.birthday_at	.val('');
			},
			always : function()
			{

				_form_elements.birthday_time.val('');
				_form_elements.password		.val('');
				_form_elements.hash			.val('');
				_form_elements.time			.val('');

				reinitForm();

				_is_loading = false;

				_button_element.html('Connexion');
			}
		});
	};

	this.sendPasswordLost = function()
	{
		if (_is_loading) return;

		_is_loading = true;

		_button_element	= $('#' + _form_id + ' button');

		_button_element.html(Interface.getLoaderMini());

		API.post_authPassword(_form_id,
		{
			success : function(response)
			{
				if (response.error) return;

				Message.success('Un email vient de vous être envoyé pour réinitialiser votre mot de passe.');
				Interface.hidePopup();

				_form_elements.email.val('');
			},
			always : function()
			{
				reinitForm();

				_is_loading = false;

				_button_element.html('Réinitialiser mon mot de passe');
			}
		});
	};

	function reinitForm()
	{
		_form_id		= null;
		_form_elements	= {};
	}

	/**
	 * Getters
	 */

	/**
	 * Setters
	 */

	this.setFormId = function(form_id)
	{
		_form_id = form_id;
	};

	/**
	 * Checks
	 */

	this.checkConnexionForm = function()
	{
		_form_elements.email			= $('#' + _form_id + ' input[name=email]');
		_form_elements.password_nocrypt	= $('#' + _form_id + ' input[name=password-nocrypt]');

		_form_elements.password	= $('#' + _form_id + ' input[name=password]');

		// Empty
		if (Security.empty(_form_elements.email.val()))
		{
			Message.error('Email obligatoire.');
			return false;
		}

		if (Security.empty(_form_elements.password_nocrypt.val()))
		{
			Message.error('Mot de passe obligatoire.');
			return false;
		}

		// Email
		if (!Security.email(_form_elements.email.val()))
		{
			Message.error('Email invalide.');
			return false;
		}

		return true;
	};

	this.checkRegistrationForm = function()
	{
		_form_elements.photo			= $('#' + _form_id + ' input[name=photo]');
		_form_elements.username			= $('#' + _form_id + ' input[name=username]');
		_form_elements.email			= $('#' + _form_id + ' input[name=email]');
		_form_elements.birthday_at		= $('#' + _form_id + ' input[name=birthday_at]');
		_form_elements.password_nocrypt	= $('#' + _form_id + ' input[name=password-nocrypt]');
		_form_elements.password_confirm	= $('#' + _form_id + ' input[name=password-confirm]');

		_form_elements.birthday_time	= $('#' + _form_id + ' input[name=birthday_time]');
		_form_elements.password			= $('#' + _form_id + ' input[name=password]');
		_form_elements.hash				= $('#' + _form_id + ' input[name=hash]');
		_form_elements.time				= $('#' + _form_id + ' input[name=time]');

		// Empty
		if (Security.empty(_form_elements.photo.val()))
		{
			Message.error('Avatar obligatoire.');
			return false;
		}

		if (Security.empty(_form_elements.username.val()))
		{
			Message.error('Pseudo obligatoire.');
			return false;
		}

		if (Security.empty(_form_elements.email.val()))
		{
			Message.error('Email obligatoire.');
			return false;
		}

		if (Security.empty(_form_elements.birthday_at.val()))
		{
			Message.error('Date de naissance obligatoire.');
			return false;
		}

		if (Security.empty(_form_elements.password_nocrypt.val()))
		{
			Message.error('Mot de passe obligatoire.');
			return false;
		}

		// Email
		if (!Security.email(_form_elements.email.val()))
		{
			Message.error('Email invalide.');
			return false;
		}

		// Birthday
		if (!Security.date(_form_elements.birthday_at.val()))
		{
			Message.error('Date de naissance invalide.');
			return false;
		}

		// Password
		if (!Security.size(_form_elements.password_nocrypt.val(), 8, 255))
		{
			Message.error('Le mot de passe doit faire au minimum 8 caractères.');
			return false;
		}

		// Password confirm
		if (_form_elements.password_nocrypt.val() != _form_elements.password_confirm.val())
		{
			Message.error('Mauvaise confirmation du mot de passe.');
			return false;
		}

		return true;
	};

	this.checkPasswordLostForm = function()
	{
		_form_elements.email = $('#' + _form_id + ' input[name=email]');

		// Empty
		if (Security.empty(_form_elements.email.val()))
		{
			Message.error('Email obligatoire.');
			return false;
		}

		// Email
		if (!Security.email(_form_elements.email.val()))
		{
			Message.error('Email invalide.');
			return false;
		}

		return true;
	};

}

var User = new User;