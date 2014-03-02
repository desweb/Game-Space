function Interface()
{
	var _interface_class = 'interface';

	var _loading_id	= 'loading';
	var _main_id	= 'main';
	var _game_id	= 'game';

	/**
	 * Global
	 */

	this.loading = function(complete)
	{
		$('body').prepend('<div id="' + _loading_id + '"><p>' + this.getLoader() + '</p></div>');

		$('#' + _loading_id).fadeIn(function()
		{
			if (complete) complete();
		});
	};

	this.show = function(is_scroll, complete)
	{
		if (is_scroll) $('#' + _main_id).css('overflow', 'visible');

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

		$('#' + _game_id).fadeOut();
		$('#' + _main_id).fadeOut(function()
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

		if (GameState.game()) GameState.setIsStop(true);

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
			if (is_complete) return;

			if (complete) complete();

			is_complete = true;

			if (GameState.game()) GameState.setIsStop(false);
		});
	};

	/**
	 * Phaser
	 */

	this.showMain = function(complete)
	{
		$('#' + _loading_id).fadeOut(function()
		{
			$('#' + _loading_id).remove();
		});

		$('#' + _main_id).fadeIn(function()
		{
			complete();
		});
	};

	this.showGame = function(complete)
	{
		$('#' + _loading_id).fadeOut(function()
		{
			$('#' + _loading_id).remove();
		});

		$('#' + _game_id).fadeIn(function()
		{
			complete();
		});
	};

	/**
	 * Getters
	 */

	this.getMainId = function() { return _main_id; };
	this.getGameId = function() { return _game_id; };

	this.getLoaderMini = function()
	{
		return '<img src="http://game-space.desweb-creation.fr/global/images/loader-mini.gif" alt="Chargement"/> Chargement...';
	};

	this.getLoader = function()
	{
		return '<img src="http://game-space.desweb-creation.fr/global/images/loader.gif" alt="Chargement"/> Chargement...';
	};

	this.getLoaderLarge = function()
	{
		return '<img src="http://game-space.desweb-creation.fr/global/images/loader-large.gif" alt="Chargement"/> Chargement...';
	};
}

var Interface = new Interface;