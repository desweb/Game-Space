GameMain.Player.Fires = function()
{
	Console.trace('GameMain.Player.Fires', 'constructor');

	var _group;

	var _rate_time = 500;
	var _next_time = 0;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('GameMain.Player.Fires', 'create');

		// Group
	    _group = current_game.getGame().add.group();
	    _group.createMultiple(10, 'player-fire');
	    _group.setAll('anchor.x', .5);
	    _group.setAll('anchor.y', .5);
	    _group.setAll('outOfBoundsKill', true);
	}

	/**
	 * Destroy
	 */

	function destroy()
	{
		Console.trace('GameMain.Player.Fires', 'destroy');

		_group.removeAll();
		_group.destroy();
		_group = null;

		_rate_time = null;
		_next_time = null;
	}

	/**
	 * Update
	 */

	this.update = function()
	{
		if (current_game.getCursor().isSpaceBarDown()) fire();

		for (var i in current_game.getDragons())
		{
			if (!current_game.getDragon(i).getSprite().alive) continue;

			current_game.getGame().physics.collide(_group, current_game.getDragon(i).getSprite(), hitDragon, null, this);
		}
	};

	/**
	 * Functionnalities
	 */

	function fire()
	{
		if (current_game.getGame().time.now < _next_time || _group.countDead() < 0) return;

		_next_time = current_game.getGame().time.now + _rate_time;

		var fire = _group.getFirstDead();

		fire.reset(current_game.getPlayer().getSprite().x, current_game.getPlayer().getSprite().y);

		fire.rotation = current_game.getGame().physics.moveToPointer(fire, 1000);
	}

	function hitDragon(dragon, fire)
	{
		fire.kill();
		
		dragon.damage();
	}
};