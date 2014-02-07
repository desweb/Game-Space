function GameState()
{
	var _game;

	this.launchGame = function()
	{
		Interface.loading();

		_game = new Game.Game;
	};

	this.game	= function() { return _game; };
	this.phaser	= function() { return _game.getGame(); };
	this.cursor	= function() { return _game.getCursor(); };
}

var GameState = new GameState;