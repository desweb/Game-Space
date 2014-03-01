MainGame.Player.Fires = function()
{
	Console.trace('MainGame.Player.Fires', 'constructor');

	var _group;

	var _rate_time = 500;
	var _next_time = 0;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('MainGame.Player.Fires', 'create');

		// Group
	    _group = GameState.phaser().add.group();
	    _group.createMultiple(10, 'player-fire');
	    _group.setAll('anchor.x', .5);
	    _group.setAll('anchor.y', .5);
	    _group.setAll('outOfBoundsKill', true);
	}

	/**
	 * Destroy
	 */

	this.destroy = function()
	{
		Console.trace('MainGame.Player.Fires', 'destroy');

		_group.removeAll();
		_group.destroy();
		_group = null;

		_rate_time = null;
		_next_time = null;
	};

	/**
	 * Update
	 */

	this.update = function()
	{
		for (var i in GameState.game().getDragons())
		{
			if (!GameState.game().getDragon(i).getSprite().alive) continue;

			GameState.phaser().physics.collide(_group, GameState.game().getDragon(i).getSprite(), hitDragon, null, this);
		}
	};

	/**
	 * Functionnalities
	 */

	this.fire = function()
	{
		if (GameState.phaser().time.now < _next_time || _group.countDead() < 0) return;

		_next_time = GameState.phaser().time.now + _rate_time;

		var fire = _group.getFirstDead();

		fire.reset(GameState.player().getSprite().x, GameState.player().getSprite().y);

		fire.rotation = GameState.phaser().physics.moveToPointer(fire, 1000);
	};

	function hitDragon(dragon, fire)
	{
		fire.kill();

		dragon.damage();
	}
};