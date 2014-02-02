function API()
{
	var BASE_URL = 'http://game-space.desweb-creation.fr/api/';

	var HASH_ADD		= 'FP2zCdnmaYGP9X2E';
	var HASH_UPDATE		= 'ATxuV3HbVn';
	var HASH_PASSWORD	= '9mrfSL6GfFqC79KI';

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

		datas.time = parseInt(new Date().getTime() / 1000);
		datas.hash = hashAddFacebook(facebook_datas.email, datas.time);

		postRequest('auth/facebook/' + datas.hash, datas, response_functions);
	};

	this.post_authAdd = function(form_id, response_functions)
	{
		var birthday_time	= time($('#' + form_id + ' input[name=birthday_at]').val());
		var password_crypt	= cryptPassword($('#' + form_id + ' input[name=password-nocrypt]').val());
		var timestamp		= parseInt(new Date().getTime() / 1000);
		var hash			= hashAdd($('#' + form_id + ' input[name=email]').val(), password_crypt, timestamp);

		$('#' + form_id + ' input[name=birthday_time]')	.val(birthday_time);
		$('#' + form_id + ' input[name=password]')		.val(password_crypt);
		$('#' + form_id + ' input[name=time]')			.val(timestamp);
		$('#' + form_id + ' input[name=hash]')			.val(hash);

		$('#' + form_id + ' input[name=password-nocrypt]').val('');
		$('#' + form_id + ' input[name=password-confirm]').val('');

		formRequest(form_id, 'auth/add/' + hash, response_functions);
	};

	this.post_authPassword = function(form_id, response_functions)
	{
		formRequest(form_id, 'auth/password', response_functions);
	};

	/**
	 * Contact
	 */

	this.post_contact = function(form_id, response_functions)
	{
		formRequest(form_id, 'contact', response_functions);
	};

	/**
	 * Map
	 */

	this.get_mapDatas = function(id, response_functions)
	{
		getRequest('map/' + id + '/main', response_functions);
	};

	this.post_mapMain = function(datas, response_functions)
	{
		postRequest('map/main', datas, response_functions);
	};

	this.post_map = function(datas, response_functions)
	{
		postRequest('map', datas, response_functions);
	};

	this.post_mapUpdate = function(id, datas, response_functions)
	{
		postRequest('map/' + id, datas, response_functions);
	};

	/**
	 * Functionnalities
	 */

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

				if (response_functions.success) response_functions.success(response);
				if (response_functions.always) response_functions.always();
			},
			error : function()
			{
				Message.error('Une erreur est survenue.');

				if (response_functions.fail) response_functions.fail();
				if (response_functions.always) response_functions.always();
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

	function hashUpdate(reference, time)
	{
		return $.md5(HASH_UPDATE + reference + time);
	}

	function time(date_str)
	{
		var date_array = date_str.split('/');

		return parseInt(new Date(date_array[2], date_array[1], date_array[0]).getTime() / 1000);
	}
}

var API = new API;