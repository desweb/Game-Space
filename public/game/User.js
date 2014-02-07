function User()
{
	var _is_connected	= false;
	var _is_loading		= false;

	var _form_id;
	var _link_id;

	var _form_elements = {};
	var _button_element;
	var _link_element;

	var _access_token;
	var _access_token_expired_time;

	var _reference;
	var _username;
	var _email;
	var _birthday_time;
	var _is_newsletter;
	var _facebook_id;
	var _photo_url;

	var _achievements	= new Array;
	var _games			= new Array;
	var _witnesses		= new Array;

	/**
	 * Functionnalities
	 */

	function _login(datas)
	{
		_access_token				= datas.user_token.token;
		_access_token_expired_time	= datas.user_token.expired_time;

		_reference		= datas.reference;
		_username		= datas.username;
		_email			= datas.email;
		_birthday_time	= datas.birthday_time;
		_is_newsletter	= datas.is_newsletter;
		_facebook_id	= datas.facebook_id;
		_photo_url		= datas.photo_url;

		_achievements	= datas.achievements;
		_games			= datas.games;
		_witnesses		= datas.witnesses;

		_is_connected = true;

		_displayProfil();
		_displayAvatar();
		_displayNewsletter();
	}

	function _logout()
	{
		_access_token				= null;
		_access_token_expired_time	= null;

		_reference		= null;
		_username		= null;
		_email			= null;
		_birthday_time	= null;
		_is_newsletter	= null;
		_facebook_id	= null;
		_photo_url		= null;

		_achievements	= new Array;
		_games			= new Array;
		_witnesses		= new Array;

		_is_connected = false;
	}

	function _reinitForm()
	{
		_form_id		= null;
		_form_elements	= {};
	}

	function _reinitLink()
	{
		_link_element = null;
	}

	function _displayProfil()
	{
		var birthday_at	= new Date(_birthday_time);
		var birthday_m	= parseInt(birthday_at.getMonth())	+ 1;
		var birthday_d	= parseInt(birthday_at.getDate())	+ 1;

		var d = (birthday_d < 10? '0': '') + birthday_d;
		var m = (birthday_m < 10? '0': '') + birthday_m;
		var y = birthday_at.getFullYear();

		$('#profil-form input[name=username]')		.val(_username);
		$('#profil-form input[name=email]')			.val(_email);
		$('#profil-form input[name=birthday_at]')	.val(d + '/' + m + '/' + y);
	}

	function _displayAvatar()
	{
		$('#edit-avatar-preview').attr('src', _photo_url);
		$('#edit-avatar-preview').show();
	}

	function _displayNewsletter()
	{
		$('#newsletter-link').html((_is_newsletter? 'Me désinscrire de': 'M\'inscrire à') + ' la newsletter');
	}

	this.login = function()
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

				_login(response);

				Message.success('Connexion réussie.');
				Interface.hidePopup();

				_form_elements.email			.val('');
				_form_elements.password_nocrypt	.val('');
			},
			always : function()
			{
				_form_elements.password.val('');

				_reinitForm();

				_is_loading = false;

				_button_element.html('Connexion');
			}
		});
	};

	this.facebook = function(facebook_datas)
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

				_login(response);

				Message.success('Connexion réussie.');
				Interface.hidePopup();
			},
			always : function()
			{
				_reinitForm();

				_is_loading = false;

				_button_element.html('Connexion Facebook');
			}
		});
	};

	this.registration = function()
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

				_login(response);

				Message.success('Inscription réussie.');
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

				_reinitForm();

				_is_loading = false;

				_button_element.html('Connexion');
			}
		});
	};

	this.passwordLost = function()
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
				_reinitForm();

				_is_loading = false;

				_button_element.html('Réinitialiser mon mot de passe');
			}
		});
	};

	this.update = function()
	{
		if (_is_loading) return;

		_is_loading = true;

		_button_element	= $('#' + _form_id + ' button');

		_button_element.html(Interface.getLoaderMini());

		API.post_me(_form_id,
		{
			success : function(response)
			{
				if (response.error) return;

				Message.success('Mise à jour réussie.');

				_form_elements.username		.val('');
				_form_elements.email		.val('');
				_form_elements.birthday_at	.val('');

				_displayProfil();
			},
			always : function()
			{
				_form_elements.birthday_time.val('');

				_reinitForm();

				_is_loading = false;

				_button_element.html('Modifier mon profil');
			}
		});
	};

	this.avatar = function()
	{
		if (_is_loading) return;

		_is_loading = true;

		_button_element	= $('#' + _form_id + ' button');

		_button_element.html(Interface.getLoaderMini());

		API.post_meAvatar(_form_id,
		{
			success : function(response)
			{
				if (response.error) return;

				Message.success('Mise à jour réussie.');

				_photo_url = response.photo_url;

				_form_elements.photo.val('');

				_displayAvatar();
			},
			always : function()
			{
				_reinitForm();

				_is_loading = false;

				_button_element.html('Modifier mon avatar');
			}
		});
	};

	this.password = function()
	{
		if (_is_loading) return;

		_is_loading = true;

		_button_element	= $('#' + _form_id + ' button');

		_button_element.html(Interface.getLoaderMini());

		API.post_mePassword(_form_id,
		{
			success : function(response)
			{
				if (response.error) return;

				Message.success('Mise à jour réussie.');
			},
			always : function()
			{
				_form_elements.old_password	.val('');
				_form_elements.password		.val('');

				_reinitForm();

				_is_loading = false;

				_button_element.html('Modifier mon mot de passe');
			}
		});
	};

	this.newsletter = function()
	{
		if (_is_loading) return;

		_is_loading = true;

		_link_element = $('#' + _link_id + '');

		_link_element.html(Interface.getLoaderMini());

		API.post_meNewsletter({
			success : function(response)
			{
				if (response.error) return;

				_is_newsletter = !_is_newsletter;

				Message.success('Vous avez été ' + (_is_newsletter? 'inscris à': 'désinscris de') + ' la newsletter.');
			},
			always : function()
			{
				_reinitLink();

				_is_loading = false;

				_displayNewsletter();
			}
		});
	};

	this.logout = function()
	{
		if (_is_loading) return;

		_is_loading = true;

		_link_element = $('#' + _link_id + '');

		_link_element.html(Interface.getLoaderMini());

		API.delete_auth({
			success : function(response)
			{
				if (response.error) return;

				_logout();

				Message.success('Déconnexion réussie.');
				Interface.hidePopup();
			},
			always : function()
			{
				_link_element.html('Me déconnecter');
				_reinitLink();

				_is_loading = false;
			}
		});
	};

	this.delete = function()
	{
		if (_is_loading) return;

		if (!confirm('Êtes-vous sûr de vouloir supprimer définitivement votre compte ?')) return;

		_is_loading = true;

		_link_element = $('#' + _link_id + '');

		_link_element.html(Interface.getLoaderMini());

		API.delete_me({
			success : function(response)
			{
				if (response.error) return;

				_logout();

				Message.success('Suppression réussie.');
				Interface.hidePopup();
			},
			always : function()
			{
				_link_element.html('Supprimer mon compte');
				_reinitLink();

				_is_loading = false;
			}
		});
	};

	/**
	 * Getters
	 */

	this.getAccessToken = function()
	{
		return _access_token;
	};

	this.getAccessTokenExpiredTime = function()
	{
		return _access_token_expired_time;
	};

	this.getReference = function()
	{
		return _reference;
	};

	/**
	 * Setters
	 */

	this.setFormId = function(form_id)
	{
		_form_id = form_id;
	};

	this.setLinkId = function(link_id)
	{
		_link_id = link_id;
	};

	this.setAccessToken = function(access_token)
	{
		_access_token = access_token;
	};

	this.setAccessTokenExpiredTime = function(access_token_expired_time)
	{
		_access_token_expired_time = access_token_expired_time;
	};

	/**
	 * Checks
	 */

	this.isConnected = function()
	{
		return _is_connected;
	};

	this.isNewsletter = function()
	{
		return _is_newsletter;
	};

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

	this.checkUpdateForm = function()
	{
		_form_elements.username		= $('#' + _form_id + ' input[name=username]');
		_form_elements.email		= $('#' + _form_id + ' input[name=email]');
		_form_elements.birthday_at	= $('#' + _form_id + ' input[name=birthday_at]');

		_form_elements.birthday_time	= $('#' + _form_id + ' input[name=birthday_time]');

		// Empty
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

		return true;
	};

	this.checkAvatarForm = function()
	{
		_form_elements.photo = $('#' + _form_id + ' input[name=photo]');

		// Empty
		if (Security.empty(_form_elements.photo.val()))
		{
			Message.error('Avatar obligatoire.');
			return false;
		}

		return true;
	};

	this.checkPasswordForm = function()
	{
		_form_elements.old_password_nocrypt	= $('#' + _form_id + ' input[name=old_password-nocrypt]');
		_form_elements.password_nocrypt		= $('#' + _form_id + ' input[name=password-nocrypt]');
		_form_elements.password_confirm		= $('#' + _form_id + ' input[name=password-confirm]');

		_form_elements.old_password	= $('#' + _form_id + ' input[name=old_password]');
		_form_elements.password		= $('#' + _form_id + ' input[name=password]');

		// Empty
		if (Security.empty(_form_elements.old_password_nocrypt.val()))
		{
			Message.error('Mot de passe obligatoire.');
			return false;
		}

		if (Security.empty(_form_elements.password_nocrypt.val()))
		{
			Message.error('Nouveau mot de passe obligatoire.');
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

}

var User = new User;