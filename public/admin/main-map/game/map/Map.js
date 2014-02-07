Game.Map.Map = function()
{
	Console.trace('Game.Map.Map', 'constructor');

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
		Console.trace('Game.Map.Map', 'create');

		_sprite = GameState.phaser().add.sprite(0, 0, 'map');
		_sprite.inputEnabled = true;

		_sprite.events.onInputOver	.add(overSprite,this);
		_sprite.events.onInputOut	.add(outSprite,	this);
		_sprite.events.onInputDown	.add(downSprite,this);
		_sprite.events.onInputUp	.add(upSprite,	this);
	}

	/**
	 * Update
	 */

	this.update = function()
	{
		// Drag & drop
		if (_is_over && _is_down)
		{
			if (_old_position.x) GameState.phaser().camera.x += _old_position.x - GameState.cursor().getPointer().x;
			if (_old_position.y) GameState.phaser().camera.y += _old_position.y - GameState.cursor().getPointer().y;

			_old_position.x = GameState.cursor().getPointer().x;
			_old_position.y = GameState.cursor().getPointer().y;
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