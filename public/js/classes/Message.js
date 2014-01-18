function Message()
{
	var DIV_ID = 'infos';

	var DISPLAY_TIME = 3000;

	var _timeout;

	this.info = function(content)
	{
		display(content);
	};

	this.success = function(content)
	{
		display('<span class="success">' + content + '</span>');
	};

	this.error = function(content)
	{
		display('<span class="error">' + content + '</span>');
	};

	/**
	 * Functionnalities
	 */

	function display(content)
	{
		$('#' + DIV_ID).remove();

		destroyTimeout();

		$('body').prepend('<div id="' + DIV_ID + '"/>');

		$('#' + DIV_ID).html(content);

		$('#' + DIV_ID).fadeIn();

		_timeout = setTimeout(function()
		{
			$('#' + DIV_ID).fadeOut(function()
			{
				$('#' + DIV_ID).remove();
				destroyTimeout();
			});
		}, DISPLAY_TIME);
	}

	function destroyTimeout()
	{
		if (_timeout) clearTimeout(_timeout);

		_timeout = null;
	}
}

var Message = new Message();