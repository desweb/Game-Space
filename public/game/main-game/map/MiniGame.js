MainGame.Map.MiniGame = function(id)
{
	Console.trace('MainGame.Map.MiniGame', 'constructor');

	var _id = id;

	var _sprite;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('MainGame.Map.MiniGame', 'create');

		_sprite = GameState.phaser().add.sprite(Common.main_game.mini_games[_id].datas.pos.x, Common.main_game.mini_games[_id].datas.pos.y, 'mini-game');
		_sprite.anchor.setTo(.5, .5);

		_sprite.inputEnabled = true;
		_sprite.events.onInputOver	.add(over,	this);
		_sprite.events.onInputOut	.add(out,	this);
		_sprite.events.onInputDown	.add(down,	this);
		_sprite.events.onInputUp	.add(up,	this);
	}

	/**
	 * Destroy
	 */

	this.destroy = function()
	{
		Console.trace('MainGame.Map.MiniGame', 'destroy');

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
		//GameState.launchLevelMainGame(_id);
	}

	function up()
	{
		GameState.launchLevelMainGame(_id);
	}
};