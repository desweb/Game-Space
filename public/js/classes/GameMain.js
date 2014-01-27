function GameMain()
{
	Console.trace('GameMain', 'constructor');

	var _id;

	// Game
	var _game;

	// Mouse, Keyboard, touch
	var _cursor;

	// Assets
	var _images = {};

	// Map
	var _map_sprite;
	var _is_map_over = false;
	var _is_map_down = false;
	var _map_old_x;
	var _map_old_y;

	// Main game
	var _level_texts	= new Array;
	var _level_sprites	= new Array;
	var _level_datas;

	// Minis games
	var _game_texts		= new Array;
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
		_level_datas= datas.levels;

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
		_game.load.image('level',		_images.level);
		_game.load.image('game-mini',	_images.game_mini);
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

		// Map
		_map_sprite = _game.add.sprite(0, 0, 'map');
		_map_sprite.inputEnabled = true;

		_map_sprite.events.onInputOver  .add(overMapSprite,   this);
		_map_sprite.events.onInputOut   .add(outMapSprite,  this);
		_map_sprite.events.onInputDown  .add(downMapSprite,   this);
		_map_sprite.events.onInputUp    .add(upMapSprite,  this);

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

		// Display game
		Interface.show(false, function()
		{
			Message.info('Bienvenue dans la GameSpace.');
		});

		_cursor = new Cursor(_game, IS_MOBILE);
	}

	/**
	 * Update
	 */

	function update()
	{
		// Drag & drop map
		if (_is_map_over && _is_map_down)
		{
			if (_map_old_x) _game.camera.x += _map_old_x - _cursor.getPointer().x;
			if (_map_old_y) _game.camera.y += _map_old_y - _cursor.getPointer().y;

			_map_old_x = _cursor.getPointer().x;
			_map_old_y = _cursor.getPointer().y;
		}
		else
		{
			_map_old_x = null;
			_map_old_y = null;
		}

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

		// Move camera
		if		(_cursor.isTopDown())	_game.camera.y -= 200;
		else if	(_cursor.isBottomDown())_game.camera.y += 200;

		if		(_cursor.isLeftDown())	_game.camera.x -= 200;
		else if (_cursor.isRightDown())	_game.camera.x += 200;
	}

	/**
	 * Events
	 */

	function overMapSprite()
	{
		_is_map_over = true;
	}

	function outMapSprite()
	{
		_is_map_over = false;
	}

	function downMapSprite()
	{
		_is_map_down = true;
	}

	function upMapSprite()
	{
		_is_map_down = false;
	}
}