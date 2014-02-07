Game.Map.MiniGame = function(i)
{
	var _sprite;
	var _text;

	create();

	/**
	 * Create
	 */

	function create()
	{
		_sprite = GameState.phaser().add.sprite(Common.game.mini_games[i].datas.pos.x, Common.game.mini_games[i].datas.pos.y, 'mini-game');
		_sprite.anchor.setTo(.5, .5);
		_sprite.scale.setTo(.1, .1);
		_sprite.inputEnabled = true;
		_sprite.input.enableDrag(true);

		_text = GameState.phaser().add.text(_sprite.x, _sprite.y, Common.game.mini_games[i].title, Font.default());
		_text.anchor.setTo(.5, 2);
	}

	/**
	 * Update
	 */

	this.update = function()
	{
		_text.x = _sprite.x;
		_text.y = _sprite.y;
	};

	/**
	 * Getters
	 */

	this.getSprite = function()
	{
		return _sprite;
	};
};