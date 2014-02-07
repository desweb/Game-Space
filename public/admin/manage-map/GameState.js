function GameState()
{
	var _game;

	var _map_model = new Models.Map;

	this.launchGame = function()
	{
		Interface.loading();

		_game = new Game.Game;
	};

	this.game	= function() { return _game; };
	this.phaser	= function() { return _game.getGame(); };
	this.cursor	= function() { return _game.getCursor(); };

	this.mapModel = function() { return _map_model; };
}

var GameState = new GameState;