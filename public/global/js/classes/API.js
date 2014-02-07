function API()
{
	this.BASE_URL;

	this.is_loading = false;

	/**
	 * Functionnalities
	 */

	this.getRequest = function(datas, response_functions)
	{
		$.getJSON(API.BASE_URL + datas.url, datas.datas,
		function(response)
		{
			responseError(response);

			if (response_functions.success) response_functions.success(response);
		})
		.fail(function()
		{
			Message.error('Une erreur est survenue.');

			if (response_functions.fail) response_functions.fail();
		})
		.always(function()
		{
			if (response_functions.always) response_functions.always();
		});
	};

	this.postRequest = function(datas, response_functions)
	{
		$.post(API.BASE_URL + datas.url, datas.datas,
		function(response)
		{
			responseError(response);

			if (response_functions.success) response_functions.success(response);
		}, 'json')
		.fail(function()
		{
			Message.error('Une erreur est survenue.');

			if (response_functions.fail) response_functions.fail();
		})
		.always(function()
		{
			if (response_functions.always) response_functions.always();
		});
	};

	this.formRequest = function(datas, response_functions)
	{
		$.ajax({
			url			: API.BASE_URL + datas.url,
			type		: 'post',
			data		: new FormData($('form#' + datas.form_id)[0]),
			dataType	: 'json',
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
	};

	function responseError(response)
	{
		if (!response.error) return;

		var content = '';

		if (response.error.description) content += response.error.description;

		if (response.error.logs)
		{
			response.error.logs.forEach(function(log)
			{
				content += '<br>' + log;
			});
		}

		Message.error(content);
	}
}

var API = new API;