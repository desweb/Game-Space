function Message()
{
	var CONTENT_DIV_ID	= 'message-content';
	var MESSAGE_DIV_ID	= 'message';

	var ANIM_TIME	= 500;
	var DISPLAY_TIME= 2000;

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
		if (!$('#' + CONTENT_DIV_ID).length)
		{
			$('body').prepend('<div id="' + CONTENT_DIV_ID + '"></div>');

			$('#' + CONTENT_DIV_ID).css('left', ($(window).width() - 400) / 2);
		}

		var message_id = MESSAGE_DIV_ID + '-' + new Date().getTime();

		$('#' + CONTENT_DIV_ID).prepend('<div id="' + message_id + '" class="message"/>');

		$('#' + message_id).html(content);

		$('#' + message_id).fadeIn(ANIM_TIME, function()
		{
			var timeout = setTimeout(function()
			{
				$('#' + message_id).fadeOut(ANIM_TIME, function()
				{
					$('#' + message_id).remove();
					
					clearTimeout(timeout);
					timeout = null;

					if ($('#' + CONTENT_DIV_ID).html() == '') $('#' + CONTENT_DIV_ID).remove();
				});
			}, DISPLAY_TIME);
		});

	}
}

var Message = new Message;