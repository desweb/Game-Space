GameMain.Map = function(game, cursor)
{
	Console.trace('GameMain.Map', 'constructor');

	var _game	= game;
	var _cursor	= cursor;

	var _sprite;

	var _old_position = { x : 0, y : 0 };

	var _is_over = false;
	var _is_down = false;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('GameMain.Map', 'create');

		_sprite = _game.add.sprite(0, 0, 'map');
		_sprite.inputEnabled = true;

		_sprite.events.onInputOver	.add(overSprite,this);
		_sprite.events.onInputOut	.add(outSprite,	this);
		_sprite.events.onInputDown	.add(downSprite,this);
		_sprite.events.onInputUp	.add(upSprite,	this);
	}

	/**
	 * Destroy
	 */

	function destroy()
	{
		Console.trace('GameMain.Map', 'destroy');

		_old_position	= null;
		_is_over		= null;
		_is_down		= null;

		Tools.destroySprite(_sprite);
	}

	/**
	 * Update
	 */

	this.update = function()
	{
		// Drag & drop
		if (_is_over && _is_down)
		{
			if (_old_position.x) _game.camera.x += _old_position.x - _cursor.getPointer().x;
			if (_old_position.y) _game.camera.y += _old_position.y - _cursor.getPointer().y;

			_old_position.x = _cursor.getPointer().x;
			_old_position.y = _cursor.getPointer().y;
		}
		else
		{
			_old_position.x = null;
			_old_position.y = null;
		}
	};

	/**
	 * Events
	 */

	function overSprite()
	{
		_is_over = true;
	}

	function outSprite()
	{
		_is_over = false;
	}

	function downSprite()
	{
		_is_down = true;
	}

	function upSprite()
	{
		_is_down = false;
	}

};