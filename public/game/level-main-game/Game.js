LevelMainGame.Game = function()
{
	Console.trace('LevelMainGame.Game', 'constructor');

	var _sprite;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('LevelMainGame.Game', 'create');

		// World
		GameState.phaser().world.setBounds(0, 0, 2000, 2000);

		// Map
		_map = GameState.phaser().add.sprite(0, 0, 'map');

		_sprite = GameState.phaser().add.sprite(100, 100, 'mini-game');
		_sprite.anchor.setTo(.5, .5);

		_sprite.inputEnabled = true;
		_sprite.events.onInputUp.add(up, this);

		// Display game
		Interface.showGame(function()
		{
			Message.info('Lancement du niveau.');
		});
	}

	/**
	 * Destroy
	 */

	this.destroy = function()
	{
		Console.trace('LevelMainGame.Game', 'destroy');

		Tools.destroySprite(_sprite);
	};

	/**
	 * Update
	 */

	this.update = function()
	{
		// Move camera
		if		(GameState.cursor().isTopDown())	GameState.phaser().camera.y -= 200;
		else if	(GameState.cursor().isBottomDown()) GameState.phaser().camera.y += 200;

		if		(GameState.cursor().isLeftDown())	GameState.phaser().camera.x -= 200;
		else if (GameState.cursor().isRightDown())	GameState.phaser().camera.x += 200;
	};

	/**
	 * Events
	 */

	function up()
	{
		GameState.launchMainGame();
	}
};