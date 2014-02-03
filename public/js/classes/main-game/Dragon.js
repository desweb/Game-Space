MainGame.Dragon = function()
{
	Console.trace('MainGame.Dragon', 'constructor');

	var _sprite;

	var _is_destroy = false;

	var _life = 3;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('MainGame.Dragon', 'create');

		// Sprite
		_sprite = GameState.phaser().add.sprite(GameState.phaser().world.randomX, GameState.phaser().world.randomY, 'dragon');
		_sprite.anchor.setTo(.5, .5);
		_sprite.scale.setTo(.2, .2);

		_sprite.body.immovable = true;

		_sprite.angle = GameState.phaser().rnd.angle();

		GameState.phaser().physics.velocityFromRotation(_sprite.rotation, 100, _sprite.body.velocity);
	}

	/**
	 * Destroy
	 */

	function destroy()
	{
		if (_is_destroy) return;

		Console.trace('MainGame.Dragon', 'destroy');

		_is_destroy = true;

		Tools.destroySprite(_sprite);
	}

	/**
	 * Update
	 */

	this.update = function()
	{
		if (_sprite.x < -50 || _sprite.x > GameState.phaser().world.width || 
			_sprite.y < -50 || _sprite.y > GameState.phaser().world.height)
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