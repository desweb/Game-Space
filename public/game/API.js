function API()
{
	var BASE_URL = 'http://game-space.desweb-creation.fr/api/';

	var HASH_ADD		= 'FP2zCdnmaYGP9X2E';
	var HASH_UPDATE		= 'ATxuV3HbVn';
	var HASH_PASSWORD	= '9mrfSL6GfFqC79KI';

	var ACCESS_TOKEN_TIME_MARGE = 3600;

	/**
	 * Home
	 */

	this.get_home = function(response_functions)
	{
		getRequest('', response_functions);
	};

	/**
	 * Auth
	 */

	this.post_auth = function(form_id, response_functions)
	{
		var password_crypt = cryptPassword($('#' + form_id + ' input[name=password-nocrypt]').val());

		$('#' + form_id + ' input[name=password]').val(password_crypt);

		$('#' + form_id + ' input[name=password-nocrypt]').val('');

		formRequest(form_id, 'auth', response_functions);
	};

	this.post_authFacebook = function(facebook_datas, response_functions)
	{
		var datas = { datas : JSON.stringify(facebook_datas) };

		datas.time = new Date().getTime();
		datas.hash = hashAddFacebook(facebook_datas.email, datas.time);

		postRequest('auth/facebook/' + datas.hash, datas, response_functions);
	};

	this.post_authAdd = function(form_id, response_functions)
	{
		var birthday_time	= time($('#' + form_id + ' input[name=birthday_at]').val());
		var password_crypt	= cryptPassword($('#' + form_id + ' input[name=password-nocrypt]').val());
		var timestamp		= new Date().getTime();
		var hash			= hashAdd($('#' + form_id + ' input[name=email]').val(), password_crypt, timestamp);

		$('#' + form_id + ' input[name=birthday_time]')	.val(birthday_time);
		$('#' + form_id + ' input[name=password]')		.val(password_crypt);
		$('#' + form_id + ' input[name=time]')			.val(timestamp);
		$('#' + form_id + ' input[name=hash]')			.val(hash);

		$('#' + form_id + ' input[name=password-nocrypt]').val('');
		$('#' + form_id + ' input[name=password-confirm]').val('');

		formRequest(form_id, 'auth/add/' + hash, response_functions);
	};

	function _post_authUpdate(response_functions)
	{
		var datas = {};

		datas.reference	= User.getReference();
		datas.time		= new Date().getTime();
		datas.hash		= hashUpdate(datas.time);

		postRequest('auth/update/' + datas.hash, datas, response_functions);
	}

	this.post_authPassword = function(form_id, response_functions)
	{
		formRequest(form_id, 'auth/password', response_functions);
	};

	this.delete_auth = function(response_functions)
	{
		deleteRequestToken('auth/{token}', response_functions);
	};

	/**
	 * User
	 */

	this.post_me = function(form_id, response_functions)
	{
		$('#' + form_id + ' input[name=birthday_time]').val(time($('#' + form_id + ' input[name=birthday_at]').val()));

		formRequestToken(form_id, 'me/{token}', response_functions);
	};

	this.post_meAvatar = function(form_id, response_functions)
	{
		formRequestToken(form_id, 'me/{token}/photo', response_functions);
	};

	this.post_mePassword = function(form_id, response_functions)
	{
		var old_password_crypt	= cryptPassword($('#' + form_id + ' input[name=old_password-nocrypt]')	.val());
		var password_crypt		= cryptPassword($('#' + form_id + ' input[name=password-nocrypt]')		.val());

		$('#' + form_id + ' input[name=old_password]')	.val(old_password_crypt);
		$('#' + form_id + ' input[name=password]')		.val(password_crypt);

		$('#' + form_id + ' input[name=old_password-nocrypt]')	.val('');
		$('#' + form_id + ' input[name=password-nocrypt]')		.val('');
		$('#' + form_id + ' input[name=password-confirm]')		.val('');

		formRequestToken(form_id, 'me/{token}/password', response_functions);
	};

	this.post_meNewsletter = function(response_functions)
	{
		postRequestToken('me/{token}/newsletter/' + (User.isNewsletter()? '0': '1'), {}, response_functions);
	};

	this.delete_me = function(response_functions)
	{
		deleteRequestToken('me/{token}', response_functions);
	};

	/**
	 * Contact
	 */

	this.post_contact = function(form_id, response_functions)
	{
		formRequest(form_id, 'contact', response_functions);
	};

	/**
	 * Functionnalities
	 */

	function checkToken(complete)
	{
		if (User.getAccessToken() && User.getAccessTokenExpiredTime() && parseInt(new Date().getTime()) < User.getAccessTokenExpiredTime() + ACCESS_TOKEN_TIME_MARGE)
		{
			complete();
			return;
		}

		_post_authUpdate({
			success : function(response)
			{
				if (response.error) return;

				User.setAccessToken(response.token);
				User.setAccessTokenExpiredTime(response.expired_at);
			},
			always : function()
			{
				complete();
			}
		});
	}

	function getRequest(url, response_functions)
	{
		$.get(BASE_URL + url,
		function(response)
		{
			responseError(response);

			if (response_functions.success) response_functions.success(response);
		},
		'json')
		.fail(function()
		{
			Message.error('Une erreur est survenue');

			if (response_functions.fail) response_functions.fail();
		})
		.always(function()
		{
			if (response_functions.always) response_functions.always();
		});
	}

	function postRequestToken(url, datas, response_functions)
	{
		checkToken(function()
		{
			url = url.replace('{token}', User.getAccessToken())

			postRequest(url, datas, response_functions);
		});
	}

	function postRequest(url, datas, response_functions)
	{
		$.post(BASE_URL + url, datas,
		function(response)
		{
			responseError(response);

			if (response_functions.success) response_functions.success(response);
		},
		'json')
		.fail(function()
		{
			Message.error('Une erreur est survenue.');

			if (response_functions.fail) response_functions.fail();
		})
		.always(function()
		{
			if (response_functions.always) response_functions.always();
		});
	}

	function formRequestToken(form_id, url, response_functions)
	{
		checkToken(function()
		{
			url = url.replace('{token}', User.getAccessToken())

			formRequest(form_id, url, response_functions);
		});
	}

	function formRequest(form_id, url, response_functions)
	{
		$.ajax({
			url			: BASE_URL + url,
			type		: 'post',
			data		: new FormData($('form#' + form_id)[0]),
			cache		: false,
			contentType	: false,
			processData	: false,
			success		: function(response)
			{
				responseError(response);

				if (response_functions.success)	response_functions.success(response);
				if (response_functions.always)	response_functions.always();
			},
			error : function()
			{
				Message.error('Une erreur est survenue.');

				if (response_functions.fail)	response_functions.fail();
				if (response_functions.always)	response_functions.always();
			}
		});
	}

	function deleteRequestToken(url, response_functions)
	{
		checkToken(function()
		{
			url = url.replace('{token}', User.getAccessToken())

			deleteRequest(url, response_functions);
		});
	}

	function deleteRequest(url, response_functions)
	{
		$.ajax({
			url			: BASE_URL + url,
			type		: 'delete',
			dataType 	: 'json',
			cache		: false,
			contentType	: false,
			processData	: false,
			success		: function(response)
			{
				responseError(response);

				if (response_functions.success)	response_functions.success(response);
				if (response_functions.always)	response_functions.always();
			},
			error : function()
			{
				Message.error('Une erreur est survenue.');

				if (response_functions.fail)	response_functions.fail();
				if (response_functions.always)	response_functions.always();
			}
		});
	}

	function responseError(response)
	{
		if (!response.error) return;

		var content = '';

		if (response.error.description) content += response.error.description;

		if (response.error.logs)
		{
			response.error.logs.forEach(function(log)
			{
				content += '<br/>' + log;
			});
		}

		Message.error(content);
	}

	function cryptPassword(password)
	{
		return $.md5(HASH_PASSWORD + password);
	}

	function hashAdd(email, password, time)
	{
		return $.md5(HASH_ADD + email + password + time);
	}

	function hashAddFacebook(email, time)
	{
		return $.md5(HASH_ADD + email + time);
	}

	function hashUpdate(time)
	{
		return $.md5(HASH_UPDATE + User.getReference() + time);
	}

	function time(date_str)
	{
		var date_array = date_str.split('/');

		return new Date(date_array[2], date_array[1] - 1, date_array[0]).getTime();
	}
}

var API = new API;