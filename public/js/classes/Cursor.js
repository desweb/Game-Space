function Cursor(game, is_mobile)
{
	var _game		= game;
	var _is_mobile	= is_mobile;

	var _cursors = _game.input.keyboard.createCursorKeys();

	/**
	 * Functionnalities
	 */

	/**
	 * Getters
	 */

	this.getPointer = function()
	{
		return _is_mobile? _game.input.pointer1: _game.input.mousePointer;
	};

	this.getWorldPointer = function()
	{
		return { x : game.input.activePointer.worldX, y : game.input.activePointer.worldY };
	};

	/**
	 * Checks
	 */

	this.isMouseDown = function()
	{
		return _game.input.mousePointer.isDown;
	};

	this.isTopDown = function()
	{
		return _cursors.up.isDown;
	};

	this.isBottomDown = function()
	{
		return _cursors.down.isDown;
	};

	this.isLeftDown = function()
	{
		return _cursors.left.isDown;
	};

	this.isRightDown = function()
	{
		return _cursors.right.isDown;
	};
}