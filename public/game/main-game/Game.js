MainGame.Game = function()
{
	Console.trace('MainGame.Game', 'constructor');

	var CAMERA_SPEED = 20;

	var _id;

	var _is_stop = false;

	// Game
	var _game;

	// Cursor : Mouse, Keyboard, touch
	var _cursor;

	// Map
	var _map;

	// Player
	var _player;

	// Dragons
	var _dragons = new Array;

	var _dragon_rate_time = 30000;
	var _dragon_next_time = 0;

	// Main game
	var _level_sprites = new Array;

	// Minis games
	var _game_sprites = new Array;

	launch();

	/**
	 * Launch
	 */

	function launch()
	{
		Console.trace('MainGame.Game', 'launch');

		_game = new Phaser.Game($(window).width(), $(window).height(), Phaser.CANVAS, Interface.getGameId(), { preload:preload, create:create, update:update });
	};

	/**
	 * Loading
	 */

	function preload()
	{
		Console.trace('MainGame.Game', 'preload');

		_game.load.image('map',			Common.main_game.images.map);
		_game.load.image('level',		Common.main_game.images.level);
		_game.load.image('mini-game',	Common.main_game.images.mini_game);
		_game.load.image('dragon',		Common.main_game.images.dragon);
		_game.load.image('player',		Common.main_game.images.player.player);
		_game.load.image('player-fire',	Common.main_game.images.player.fire);
	}

	/**
	 * Creation
	 */

	function create()
	{
		Console.trace('MainGame.Game', 'create');

		_game.stage.scaleMode = Phaser.StageScaleMode.SHOW_ALL;

		// World
		_game.world.setBounds(0, 0, 4000, 4000);

		// Cursor
		_cursor = new Cursor;

		// Map
		_map = new MainGame.Map;

		// Main game
		for (var i in Common.main_game.levels)
		{
			_level_sprites[i] = _game.add.sprite(Common.main_game.levels[i].pos.x, Common.main_game.levels[i].pos.y, 'level');
			_level_sprites[i].anchor.setTo(.5, .5);
			_level_sprites[i].scale.setTo(.1, .1);
		}

		// Minis games
		for (var i in Common.main_game.mini_games)
		{
			_game_sprites[i] = _game.add.sprite(Common.main_game.mini_games[i].datas.pos.x, Common.main_game.mini_games[i].datas.pos.y, 'mini-game');
			_game_sprites[i].anchor.setTo(.5, .5);
			_game_sprites[i].scale.setTo(.1, .1);
		}

		// Player
		_player = new MainGame.Player.Player;

		// Display game
		Interface.show(false, function()
		{
			Message.info('Bienvenue dans la GameSpace.');

			setTimeout(function()
			{
				Message.info('Appuis sur la barre d\'espace pour tirer.');
			}, 1000);
		});
	}

	/**
	 * Destroy
	 */

	this.destroy = function()
	{
		Console.trace('MainGame.Game', 'destroy');

		// Cursor
		_cursor.destroy();
		_cursor = null;

		// Map
		_map.destroy();

		// Main game
		for (var i in _level_sprites)
		{
			Tools.destroySprite(_level_sprites[i])
			_level_sprites[i] = null;
		}
		_level_sprites = null;

		// Minis games
		for (var i in _game_sprites)
		{
			Tools.destroySprite(_game_sprites[i]);
			_game_sprites[i] = null;
		}
		_game_sprites = null;

		// Player
		_player.destroy();

		// Dragons
		for (var i in _dragons)
		{
			Tools.destroySprite(_dragons[i])
			_dragons[i] = null;
		}
		_dragons = null;

		// Datas
		_id = null;

		// Game
		_game.removeAll();
		_game.destroy();
		_game = null;
	};

	/**
	 * Update
	 */

	function update()
	{
		if (_is_stop) return;

		_map	.update();
		_player	.update();

		for (var i in _dragons) _dragons[i].update();

		// Create dragons
		if (_game.time.now > _dragon_next_time)
		{
			_dragons[_dragons.length] = new MainGame.Dragon;

			_dragon_next_time = _game.time.now + _dragon_rate_time;
		}

		// Move camera
		if		(_cursor.isTopDown())	_game.camera.y -= CAMERA_SPEED;
		else if	(_cursor.isBottomDown())_game.camera.y += CAMERA_SPEED;

		if		(_cursor.isLeftDown())	_game.camera.x -= CAMERA_SPEED;
		else if (_cursor.isRightDown())	_game.camera.x += CAMERA_SPEED;
	}

	/**
	 * Getters
	 */

	this.getGame = function()
	{
		return _game;
	};

	this.getCursor = function()
	{
		return _cursor;
	};

	this.getPlayer = function()
	{
		return _player;
	};

	this.getDragons = function()
	{
		return _dragons;
	};

	this.getDragon = function(i)
	{
		return _dragons[i];
	};

	/**
	 * Getters
	 */

	this.setIsStop = function(is_stop)
	{
		_is_stop = is_stop;
	};
};