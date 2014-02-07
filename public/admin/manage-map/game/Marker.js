Game.Marker = function()
{
	var _graphic;

	create();

	/**
	 * Create
	 */

	function create()
	{
        _graphic = GameState.phaser().add.graphics();
        _graphic.lineStyle(2, 0x000000, 1);
        _graphic.drawRect(0, 0, 32, 32);
	}

	/**
	 * Create
	 */

	this.update = function()
	{
        _graphic.x = GameState.game().getMapLayer().getTileX(GameState.cursor().getWorldPointer().x) * 32;
        _graphic.y = GameState.game().getMapLayer().getTileY(GameState.cursor().getWorldPointer().y) * 32;
	};

    /**
     * Getters
     */

    this.getGraphic = function()
    {
        return _graphic;
    };
};