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
	 * Contact
	 */

	this.post_contact = function(datas, response_functions)
	{
		postRequest('contact', datas, response_functions);
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
		console.log(datas);
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
}

var API = new API;