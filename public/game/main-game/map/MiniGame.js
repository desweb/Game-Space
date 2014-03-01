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
		_sprite.events.onInputDown.add(listener, this);
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

	function listener(e)
	{
		Console.log('MainGame.Map.MiniGame');
	}

};