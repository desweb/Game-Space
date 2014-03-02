function GameState()
{
	Console.trace('GameState', 'constructor');

	var _phaser = new Phaser.Game($(window).width(), $(window).height(), Phaser.CANVAS, Interface.getGameId(), { preload:preload, create:create, update:update });

	var _cursor;

	var _game;

	/**
	 * Preload
	 */

	function preload()
	{
		Console.trace('MainGame.Game', 'preload');

		_phaser.load.image('map',			Common.main_game.images.map);
		_phaser.load.image('level',			Common.main_game.images.level);
		_phaser.load.image('mini-game',		Common.main_game.images.mini_game);
		_phaser.load.image('dragon',		Common.main_game.images.dragon);
		_phaser.load.image('player',		Common.main_game.images.player.player);
		_phaser.load.image('player-fire',	Common.main_game.images.player.fire);
	}

	/**
	 * Create
	 */

	function create()
	{
		_phaser.stage.scaleMode = Phaser.StageScaleMode.SHOW_ALL;

		_cursor = new Cursor;

		_launchMainGame(true);
	}

	/**
	 * Update
	 */

	function update()
	{
		if (!_game) return;

		_game.update();
	}

	/**
	 * Getters
	 */

	this.game	= function() { return _game; };
	this.phaser	= function() { return _phaser; };
	this.player	= function() { return _game.getPlayer(); };
	this.cursor	= function() { return _cursor; };

	/**
	 * Functionnalities
	 */

	this.launchMainGame = function() { _launchMainGame(); };

	function _launchMainGame(is_first)
	{
		_changeGame(function()
		{
			_game = new MainGame.Game(is_first);
		});
	}

	this.launchLevelMainGame = function(id)
	{
		_changeGame(function()
		{
			_game = new LevelMainGame.Game;
		});
	};

	function _changeGame(complete)
	{
		if (!_game)
		{
			complete();
			return;
		}

		Interface.loading();

		Interface.hide(function()
		{
			_game.destroy();
			_game = null;

			_phaser.camera.x = 0;
			_phaser.camera.y = 0;

			complete();
		});
	}
}

var GameState = new GameState;