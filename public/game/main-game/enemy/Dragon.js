MainGame.Enemy.Dragon = function(id)
{
	Console.trace('MainGame.Enemy.Dragon', 'constructor');

	var _id = id;

	var _sprite;

	var _is_destroy = false;

	var _life = 3;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('MainGame.Enemy.Dragon', 'create');

		// Sprite
		_sprite = GameState.phaser().add.sprite(GameState.phaser().world.randomX, GameState.phaser().world.randomY, 'dragon');
		_sprite.anchor.setTo(.5, .5);

		_sprite.body.immovable = true;

		_sprite.angle = GameState.phaser().rnd.angle();

		GameState.phaser().physics.velocityFromRotation(_sprite.rotation, 100, _sprite.body.velocity);
	}

	/**
	 * Destroy
	 */

	this.destroy = function() { _destroy(); };

	function _destroy()
	{
		if (_is_destroy) return;

		Console.trace('MainGame.Enemy.Dragon', 'destroy');

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
			this.destroy();
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

		if (_life) return;

		_destroy();
		GameState.game().killDragonArray(_id);
	};
};