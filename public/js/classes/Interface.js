function Interface()
{
	var _interface_class = 'interface';

	var _loading_id	= 'loading';
	var _game_id	= 'game';

	/**
	 * Global
	 */

	this.loading = function(complete)
	{
		$('body').prepend('<div id="' + _loading_id + '"><p>' + this.getLoader() + '</p></div>');
		$('body').append('<div id="' + _game_id + '" class="' + _interface_class + '"></div>');

		$('#' + _loading_id).fadeIn(function()
		{
			if (complete) complete();
		});
	};

	this.show = function(is_scroll, complete)
	{
		if (is_scroll) $('#' + _game_id).css('overflow', 'visible');

		var is_complete = false;

		$('#' + _loading_id).fadeOut(function()
		{
			$('#' + _loading_id).remove();
		});

		$('.' + _interface_class).fadeIn(function()
		{
			if (is_complete || !complete) return;

			complete();
			is_complete = true;
		});
	};

	this.hide = function(complete)
	{
		$('.' + _interface_class).fadeOut();

		$('#' + _game_id).fadeOut(function()
		{
			if (complete) complete();
		});
	};

	/**
	 * Popup
	 */

	this.showPopup = function(id, complete)
	{
		var is_complete = false;

		$('#mask').fadeIn();
		$('#' + id).fadeIn(function()
		{
			if (is_complete || !complete) return;

			complete();
			is_complete = true;
		});
	};

	this.hidePopup = function(complete)
	{
		var is_complete = false;

		$('#mask').fadeOut();
		$('.popup').fadeOut(function()
		{
			if (is_complete || !complete) return;

			complete();
			is_complete = true;
		});
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