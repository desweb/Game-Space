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
		_sprite.alpha = .5;

		_sprite.inputEnabled = true;
		_sprite.events.onInputOver	.add(over,	this);
		_sprite.events.onInputOut	.add(out,	this);
		_sprite.events.onInputUp	.add(up,	this);
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
		GameState.phaser().add.tween(_sprite.scale)	.to({ x : 1.2 , y : 1.2 },	1000, Phaser.Easing.Bounce.Out, true, 0, false);
		GameState.phaser().add.tween(_sprite)		.to({ alpha : 1 },			1000, Phaser.Easing.Bounce.Out, true, 0, false);
	}

	function out()
	{
		GameState.phaser().add.tween(_sprite.scale)	.to({ x : 1 , y : 1 },	1000, Phaser.Easing.Bounce.Out, true, 0, false);
		GameState.phaser().add.tween(_sprite)		.to({ alpha : .5 },		1000, Phaser.Easing.Bounce.Out, true, 0, false);
	}

	function up()
	{
		GameState.launchLevelMainGame(_id);
	}
};