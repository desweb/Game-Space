MainGame.Game = function(is_first)
{
	Console.trace('MainGame.Game', 'constructor');

	var CAMERA_SPEED = 20;

	var _is_first = is_first;

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

	create();

	/**
	 * Creation
	 */

	function create()
	{
		Console.trace('MainGame.Game', 'create');

		// World
		GameState.phaser().world.setBounds(0, 0, 4000, 4000);

		// Map
		_map = new MainGame.Map.Map;

		// Main game
		for (var i in Common.main_game.levels) _level_sprites[i] = new MainGame.Map.Level(i);

		// Minis games
		for (var i in Common.main_game.mini_games) _game_sprites[i] = new MainGame.Map.MiniGame(i);

		// Player
		_player = new MainGame.Player.Player;

		// Display game
		Interface.show(false, function()
		{
			if (_is_first) Message.info('Bienvenue dans la GameSpace.');

			setTimeout(function()
			{
				Message.info('Sers toi des flèches pour te déplacer et du clic droit pour tirer.');
			}, 1000);
		});
	}

	/**
	 * Destroy
	 */

	this.destroy = function()
	{
		Console.trace('MainGame.Game', 'destroy');

		// Main game
		for (var i in _level_sprites)
		{
			_level_sprites[i].destroy();
			_level_sprites[i] = null;
		}
		_level_sprites = null;

		// Minis games
		for (var i in _game_sprites)
		{
			_game_sprites[i].destroy();
			_game_sprites[i] = null;
		}
		_game_sprites = null;

		// Player
		_player.destroy();

		// Dragons
		for (var i in _dragons)
		{
			if (!_dragons[i]) continue;

			_dragons[i].destroy();
			_dragons[i] = null;
		}
		_dragons = null;

		// Map
		_map.destroy();
	};

	/**
	 * Update
	 */

	//function update()
	this.update = function()
	{
		_player.update();

		for (var i in _dragons)
		{
			if (_dragons[i]) _dragons[i].update();
		}

		// Create dragons
		if (GameState.phaser().time.now > _dragon_next_time)
		{
			_dragons[_dragons.length] = new MainGame.Enemy.Dragon(_dragons.length);

			_dragon_next_time = GameState.phaser().time.now + _dragon_rate_time;
		}

		// Move camera
		if		(GameState.cursor().isTopDown())	GameState.phaser().camera.y -= CAMERA_SPEED;
		else if	(GameState.cursor().isBottomDown()) GameState.phaser().camera.y += CAMERA_SPEED;

		if		(GameState.cursor().isLeftDown())	GameState.phaser().camera.x -= CAMERA_SPEED;
		else if (GameState.cursor().isRightDown())	GameState.phaser().camera.x += CAMERA_SPEED;
	};

	/**
	 * Getters
	 */

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
	 * Functionnalities
	 */

	this.killDragonArray = function(i)
	{
		_dragons[i] = null;
	};
};