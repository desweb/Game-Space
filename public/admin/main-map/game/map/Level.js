Game.Map.Level = function(i)
{
	var _sprite;
	var _text;

	create();

	/**
	 * Create
	 */

	function create()
	{
		_sprite = GameState.phaser().add.sprite(Common.game.levels[i].pos.x, Common.game.levels[i].pos.y, 'level');
		_sprite.anchor.setTo(.5, .5);
		_sprite.scale.setTo(.1, .1);
		_sprite.inputEnabled = true;
		_sprite.input.enableDrag(true);

		_text = GameState.phaser().add.text(_sprite.x, _sprite.y, 'Jeu principal - Niveau ' + (parseInt(i) + 1), Font.default());
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