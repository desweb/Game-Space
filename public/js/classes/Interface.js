function Interface()
{
	var ANIM_TIME = 500;

	var _loading_id	= 'loading';
	var _game_id	= 'game';

	this.loading = function(complete)
	{
		$('body').prepend('<div id="' + _loading_id + '">' + this.getLoader() + '</div>');
		$('body').append('<div id="' + _game_id + '" class="interface"></div>');

		$('#loading').fadeIn(ANIM_TIME, function()
		{
			if (complete) complete();
		});
	};

	this.show = function(is_scroll, complete)
	{
		if (is_scroll) $('#' + _game_id).css('overflow', 'visible');

		var is_complete = false;

		$('#' + _loading_id).fadeOut(ANIM_TIME, function()
		{
			$('#' + _loading_id).remove();
		});

		$('.interface').fadeIn(ANIM_TIME, function()
		{
			if (is_complete || !complete) return;

			complete();
			is_complete = true;
		});
	};

	this.fadeIn = function(element)
	{

	};

	/**
	 * Getters
	 */

	this.getGameId = function() { return _game_id; };

	this.getLoaderMini = function()
	{
		return '<img src="http://game-space.desweb-creation.fr/images/loader-mini.gif" alt="Chargement"/> Chargement...';
	};

	this.getLoader = function()
	{
		return '<img src="http://game-space.desweb-creation.fr/images/loader.gif" alt="Chargement"/> Chargement...';
	};

	this.getLoaderLarge = function()
	{
		return '<img src="http://game-space.desweb-creation.fr/images/loader-large.gif" alt="Chargement"/> Chargement...';
	};
}

var Interface = new Interface;