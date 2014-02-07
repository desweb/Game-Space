function Cursor()
{
	var _cursors = GameState.phaser().input.keyboard.createCursorKeys();

	/**
	 * Getters
	 */

	this.getPointer = function()
	{
		return IS_MOBILE? GameState.phaser().input.pointer1: GameState.phaser().input.mousePointer;
	};

	/**
	 * Checks
	 */

	this.isPointerDown = function()
	{
		return IS_MOBILE? GameState.phaser().input.pointer1.isDown: GameState.phaser().input.mousePointer.isDown;
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