function API()
{
	var BASE_URL = 'http://game-space.desweb-creation.fr/api/';

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

	this.post_auth = function()
	{
	};

	/**
	 * Map
	 */

	this.post_mapMain = function(datas, response_functions)
	{
		postRequest('map/main', datas, response_functions);
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
			Message.error('Une erreur est survenue');

			if (response_functions.fail) response_functions.fail();
		})
		.always(function()
		{
			if (response_functions.always) response_functions.always();
		});
	}

	function responseError(response)
	{
		if (!response.error) return;

		if (response.error.description) Message.error(response.error.description);
	}
}

var API = new API();