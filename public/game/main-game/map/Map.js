MainGame.Map.Map = function()
{
	Console.trace('MainGame.Map.Map', 'constructor');

	var _sprite;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('MainGame.Map.Map', 'create');

		_sprite = GameState.phaser().add.sprite(0, 0, 'map');
		
		_sprite.inputEnabled = true;
		_sprite.events.onInputDown.add(down, this);
	}

	/**
	 * Destroy
	 */

	this.destroy = function()
	{
		Console.trace('MainGame.Map.Map', 'destroy');

		Tools.destroySprite(_sprite);
	};

	/**
	 * Events
	 */

	function down()
	{
		GameState.player().fire();
	}
};