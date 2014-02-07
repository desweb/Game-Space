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

	this.getWorldPointer = function()
	{
		return { x : GameState.phaser().input.activePointer.worldX, y : GameState.phaser().input.activePointer.worldY };
	};

	/**
	 * Checks
	 */

	this.isPointerDown = function()
	{
		return IS_MOBILE? GameState.phaser().input.pointer1.isDown: GameState.phaser().input.mousePointer.isDown;
	};
}