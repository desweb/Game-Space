function GameState()
{
	var _game;

	this.launchMainGame = function()
	{
		Interface.loading();

		_destroyGame();

		_game = new MainGame.Game;
	};

	this.launchLevelMainGame = function(id)
	{
		Interface.loading();

		_destroyGame();

		//_game = new MainGame.Game;
	};

	function _destroyGame()
	{
		if (!_game) return;

		Interface.hide(function()
		{
			_game.destroy();
			_game = null;

			Interface.destroyGame();
		});
	}

	this.game	= function() { return _game; };
	this.phaser	= function() { return _game.getGame(); };
	this.player	= function() { return _game.getPlayer(); };
	this.cursor	= function() { return _game.getCursor(); };
}

var GameState = new GameState;