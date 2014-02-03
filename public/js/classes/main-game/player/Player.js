MainGame.Player.Player = function()
{
	Console.trace('MainGame.Player.Player', 'constructor');

	var _sprite;

	var _old_position = { x : 0, y : 0 };

	var _fires;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('MainGame.Player.Player', 'create');

		// Sprite
		_sprite = GameState.phaser().add.sprite(0, 0, 'player');
		_sprite.anchor.setTo(.5, .5);
		_sprite.scale.setTo(.3, .3);

		// Fires
	    _fires = new MainGame.Player.Fires;
	}

	/**
	 * Destroy
	 */

	function destroy()
	{
		Console.trace('MainGame.Player.Player', 'destroy');

		_fires.destroy();
		_fires = null;

		_old_position = null;

		Tools.destroySprite(_sprite);
	}

	/**
	 * Update
	 */

	this.update = function()
	{
		_sprite.x = GameState.phaser().camera.x + GameState.phaser().camera.width	/2;
		_sprite.y = GameState.phaser().camera.y + GameState.phaser().camera.height/2;

		orientation();

		_fires.update();
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

	function orientation()
	{
		if (_old_position.x == _sprite.x && _old_position.y == _sprite.y)
		{
			_sprite.angle = 0;
			return;
		}

		if		(_old_position.x ==	_sprite.x && _old_position.y >	_sprite.y) _sprite.angle = 0;	// Top
		else if	(_old_position.x <	_sprite.x && _old_position.y >	_sprite.y) _sprite.angle = 45;	// Top/Right
		else if	(_old_position.x <	_sprite.x && _old_position.y ==	_sprite.y) _sprite.angle = 90;	// Right
		else if	(_old_position.x <	_sprite.x && _old_position.y <	_sprite.y) _sprite.angle = 135;	// Bottom/Right
		else if	(_old_position.x ==	_sprite.x && _old_position.y <	_sprite.y) _sprite.angle = 180;	// Bottom
		else if	(_old_position.x >	_sprite.x && _old_position.y <	_sprite.y) _sprite.angle = 225;	// Bottom/Left
		else if	(_old_position.x >	_sprite.x && _old_position.y ==	_sprite.y) _sprite.angle = 270;	// Left
		else if	(_old_position.x >	_sprite.x && _old_position.y >	_sprite.y) _sprite.angle = 315;	// Top/Left

		_old_position.x = _sprite.x;
		_old_position.y = _sprite.y;
	}
}