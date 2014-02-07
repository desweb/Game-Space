Game.Game = function()
{
	Console.trace('MainGame.Game', 'constructor');

	var CAMERA_SPEED = 20;

	var _id = Common.game.id;

	// Game
	var _game;

	// Cursor : Mouse, Keyboard, touch
	var _cursor;

	// Map
	var _map;

	// Current save
	var _is_save = false;

	// Main game
	var _levels = new Array;

	// Minis games
	var _mini_games = new Array;

	launch();

	/**
	 * Launch
	 */

	function launch()
	{
		Console.trace('Game.Game', 'launch');

		_game = new Phaser.Game($(window).width(), $(window).height() - 60, Phaser.CANVAS, Interface.getGameId(), { preload:preload, create:create, update:update });
	};

	/**
	 * Loading
	 */

	function preload()
	{
		Console.trace('Game.Game', 'preload');

		_game.load.image('map',			Common.game.images.map);
		_game.load.image('level',		Common.game.images.level);
		_game.load.image('mini-game',	Common.game.images.mini_game);
	}

	/**
	 * Creation
	 */

	function create()
	{
		Console.trace('Game.Game', 'create');

		_game.stage.scaleMode = Phaser.StageScaleMode.SHOW_ALL;

		// World
		_game.world.setBounds(0, 0, 4000, 4000);

		// Cursor
		_cursor = new Cursor;

		// Map
		_map = new Game.Map.Map;

		// Main game
		for (var i in Common.game.levels) _levels[i] = new Game.Map.Level(i);

		// Minis games
		for (var i in Common.game.mini_games) _mini_games[i] = new Game.Map.MiniGame(i);

		// Display game
		Interface.show(false, function()
		{
			Message.info('Glisser/Déposer les icônes.');
		});
	}

	function update()
	{
		// Map
		_map.update();

		// Main game
		for (var i in _levels) _levels[i].update();

		// Minis games
		for (var i in _mini_games) _mini_games[i].update();

		// Camera
		if		(_cursor.isTopDown())	_game.camera.y -= CAMERA_SPEED;
		else if	(_cursor.isBottomDown())_game.camera.y += CAMERA_SPEED;

		if		(_cursor.isLeftDown())	_game.camera.x -= CAMERA_SPEED;
		else if	(_cursor.isRightDown())	_game.camera.x += CAMERA_SPEED;
	}

	/**
	 * Getters
	 */

	this.getId = function()
	{
		return _id;
	};

	this.getGame = function()
	{
		return _game;
	};

	this.getCursor = function()
	{
		return _cursor;
	};

	this.getLevels = function()
	{
		return _levels;
	};

	this.getLevel = function(i)
	{
		return _levels[i];
	};

	this.getMiniGames = function()
	{
		return _mini_games;
	};

	this.getMiniGame = function(i)
	{
		return _mini_games[i];
	};

	/**
	 * Setters
	 */

	this.setIsSave = function(is_save)
	{
		_is_save = is_save;
	};

	/**
	 * Checks
	 */

	this.isSave = function()
	{
		return _is_save;
	};
};