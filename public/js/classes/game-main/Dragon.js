GameMain.Dragon = function()
{
	Console.trace('GameMain.Dragon', 'constructor');

	var _sprite;

	var _is_destroy = false;

	var _life = 3;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('GameMain.Dragon', 'create');

		// Sprite
		_sprite = current_game.getGame().add.sprite(current_game.getGame().world.randomX, current_game.getGame().world.randomY, 'dragon');
		_sprite.anchor.setTo(.5, .5);
		_sprite.scale.setTo(.2, .2);

		_sprite.body.immovable = true;

		_sprite.angle = current_game.getGame().rnd.angle();

		current_game.getGame().physics.velocityFromRotation(_sprite.rotation, 100, _sprite.body.velocity);
	}

	/**
	 * Destroy
	 */

	function destroy()
	{
		if (_is_destroy) return;

		Console.trace('GameMain.Dragon', 'destroy');

		_is_destroy = true;

		Tools.destroySprite(_sprite);
	}

	/**
	 * Update
	 */

	this.update = function()
	{
		if (_sprite.x < -50 || _sprite.x > current_game.getGame().world.width || 
			_sprite.y < -50 || _sprite.y > current_game.getGame().world.height)
			destroy();
	};

	/**
	 * Getters
	 */

	this.getSprite = function()
	{
		return _sprite;
	};

	/**
	 * Functionnalities
	 */

	_sprite.damage = function()
	{
		_life--;

		if (_life <= 0) destroy();
	};
};