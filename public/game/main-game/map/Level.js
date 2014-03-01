MainGame.Map.Level = function(id)
{
	Console.trace('MainGame.Map.Level', 'constructor');

	var _id = id;

	var _sprite;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('MainGame.Map.Level', 'create');

		_sprite = GameState.phaser().add.sprite(Common.main_game.levels[_id].pos.x, Common.main_game.levels[_id].pos.y, 'level');
		_sprite.anchor.setTo(.5, .5);

		_sprite.inputEnabled = true;
		_sprite.events.onInputOver	.add(over,	this);
		_sprite.events.onInputOut	.add(out,	this);
		_sprite.events.onInputDown	.add(down,	this);
	}

	/**
	 * Destroy
	 */

	this.destroy = function()
	{
		Console.trace('MainGame.Map.Level', 'destroy');

		_id = null;

		Tools.destroySprite(_sprite);
	};

	/**
	 * Events
	 */

	function over()
	{
		_sprite.scale.setTo(1.1, 1.1);
	}

	function out()
	{
		_sprite.scale.setTo(1, 1);
	}

	function down()
	{
		GameState.launchLevelMainGame(_id);
	}
};