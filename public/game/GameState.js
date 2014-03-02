function GameState()
{
	Console.trace('GameState', 'constructor');

	var _main_phaser = new Phaser.Game($(window).width(),	$(window).height(),	Phaser.CANVAS, Interface.getMainId(), { preload:mainPreload, create:mainCreate, update:mainUpdate });
	var _game_phaser = new Phaser.Game(800,					600,				Phaser.CANVAS, Interface.getGameId(), { preload:gamePreload, create:gameCreate, update:gameUpdate });

	var _main_cursor;
	var _game_cursor;

	var _is_main		= false;
	var _is_game		= false;
	var _is_main_load	= false;
	var _is_game_load	= false;

	var _is_stop = false;

	var _game;

	/**
	 * Preload
	 */

	function mainPreload()
	{
		Console.trace('MainGame.Game', 'preload');

		_main_phaser.load.image('map',			Common.main_game.images.map);
		_main_phaser.load.image('level',		Common.main_game.images.level);
		_main_phaser.load.image('mini-game',	Common.main_game.images.mini_game);
		_main_phaser.load.image('dragon',		Common.main_game.images.dragon);
		_main_phaser.load.image('player',		Common.main_game.images.player.player);
		_main_phaser.load.image('player-fire',	Common.main_game.images.player.fire);
	}

	function gamePreload()
	{
		Console.trace('MainGame.Game', 'preload');

		_game_phaser.load.image('map',		Common.main_game.images.map);
		_game_phaser.load.image('mini-game',Common.main_game.images.mini_game);
	}

	/**
	 * Create
	 */

	function mainCreate()
	{
		_main_phaser.stage.scaleMode = Phaser.StageScaleMode.SHOW_ALL;
		_main_phaser.stage.backgroundColor = '#000';

		_main_cursor = new Cursor(_main_phaser);

		_is_main_load = true;

		launch();
	}

	function gameCreate()
	{
		_game_phaser.stage.scaleMode = Phaser.StageScaleMode.SHOW_ALL;
		_game_phaser.stage.backgroundColor = '#000';

		_game_cursor = new Cursor(_game_phaser);

		_is_game_load = true;

		launch();
	}

	function launch()
	{
		if (!_is_main_load || !_is_game_load) return;

		_launchMainGame(true);
	}

	/**
	 * Update
	 */

	function mainUpdate()
	{
		if (_is_main) update();
	}

	function gameUpdate()
	{
		if (_is_game) update();
	}

	function update()
	{
		if (!_game || _is_stop) return;

		_game.update();
	}

	/**
	 * Getters
	 */

	this.game	= function() { return _game; };
	this.phaser	= function() { return _is_main? _main_phaser: _game_phaser; };
	this.player	= function() { return _game.getPlayer(); };
	this.cursor	= function() { return _is_main? _main_cursor: _game_cursor; };

	/**
	 * Setters
	 */

	this.setIsStop = function(is_stop) { _is_stop = is_stop; };

	/**
	 * Functionnalities
	 */

	this.launchMainGame = function() { _launchMainGame(); };

	function _launchMainGame(is_first)
	{
		_changeGame(function()
		{
			_is_game = false;
			_is_main = true;

			_game = new MainGame.Game(is_first);
		});
	}

	this.launchLevelMainGame = function(id)
	{
		_changeGame(function()
		{
			_is_main = false;
			_is_game = true;

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

			_main_phaser.camera.x = 0;
			_main_phaser.camera.y = 0;
			_game_phaser.camera.x = 0;
			_game_phaser.camera.y = 0;

			complete();
		});
	}
}

var GameState = new GameState;