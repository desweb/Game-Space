GameMain.Game = function()
{
	Console.trace('GameMain', 'constructor');

	var CAMERA_SPEED = 20;

	var _id;

	// Game
	var _game;

	// Cursor : Mouse, Keyboard, touch
	var _cursor;

	// Assets
	var _images = {};

	// Map
	var _map;

	// Player
	var _player;

	// Dragons
	var _dragons = new Array;

	var _dragon_rate_time = 30000;
	var _dragon_next_time = 0;

	// Main game
	var _level_sprites	= new Array;
	var _level_datas;

	// Minis games
	var _game_sprites	= new Array;
	var _game_datas;

	/**
	 * Init
	 */

	this.init = function(datas)
	{
		Console.trace('GameMain', 'constructor', datas);

		_images = datas.images;

		_id			= datas.game_main_datas.id;
		_level_datas= datas.game_main_datas.levels;

		_game_datas	= datas.game_datas;
	};

	/**
	 * Launch
	 */

	this.launch = function()
	{
		Console.trace('GameMain', 'launch');

		Interface.loading();

		_game = new Phaser.Game($(window).width(), $(window).height(), Phaser.CANVAS, Interface.getGameId(), { preload:preload, create:create, update:update });
	};

	/**
	 * Loading
	 */

	function preload()
	{
		Console.trace('GameMain', 'preload');

		_game.load.image('map',			_images.map);
		_game.load.image('player',		_images.level);
		_game.load.image('level',		_images.level);
		_game.load.image('game-mini',	_images.game_mini);
		_game.load.image('player-fire',	_images.player_fire);
		_game.load.image('dragon',		_images.level);
	}

	/**
	 * Creation
	 */

	function create()
	{
		Console.trace('GameMain', 'create');

		_game.stage.scaleMode = Phaser.StageScaleMode.SHOW_ALL;

		// World
		_game.world.setBounds(0, 0, 4000, 4000);

		// Cursor
		_cursor = new Cursor(_game, IS_MOBILE);

		// Map
		_map = new GameMain.Map(_game, _cursor);

		// Main game
		for (var i in _level_datas)
		{
			_level_sprites[i] = _game.add.sprite(_level_datas[i].pos.x, _level_datas[i].pos.y, 'level');
			_level_sprites[i].anchor.setTo(.5, .5);
			_level_sprites[i].scale.setTo(.1, .1);
		}

		// Minis games
		for (var i in _game_datas)
		{
			_game_sprites[i] = _game.add.sprite(_game_datas[i].datas.pos.x, _game_datas[i].datas.pos.y, 'game-mini');
			_game_sprites[i].anchor.setTo(.5, .5);
			_game_sprites[i].scale.setTo(.1, .1);
		}

		// Player
		_player = new GameMain.Player;

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
		Console.trace('GameMain', 'destroy');

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
		_id			= null;
		_images		= null;
		_level_datas= null;
		_game_datas	= null;

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
		_map	.update();
		_player	.update();

		for (var i in _dragons) _dragons[i].update();

		// Main game
		/*for (var i in _level_sprites)
		{
			_level_texts[i].x = _level_sprites[i].x;
			_level_texts[i].y = _level_sprites[i].y;
		}

		// Minis games
		for (var i in _game_sprites)
		{
			_game_texts[i].x = _game_sprites[i].x;
			_game_texts[i].y = _game_sprites[i].y;
		}*/

		// Create dragons
		if (_game.time.now > _dragon_next_time)
		{
			_dragons[_dragons.length] = new GameMain.Dragon;

			_dragon_next_time = _game.time.now + _dragon_rate_time;
		}

		// Move camera
		if		(_cursor.isTopDown())	_game.camera.y -= CAMERA_SPEED;
		else if	(_cursor.isBottomDown())_game.camera.y += CAMERA_SPEED;

		if		(_cursor.isLeftDown())	_game.camera.x -= CAMERA_SPEED;
		else if (_cursor.isRightDown())	_game.camera.x += CAMERA_SPEED;
	}

	/**
	 * Events
	 */

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
}