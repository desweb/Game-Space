function Cursor()
{
	Console.trace('Cursor', 'constructor');

	var _cursors;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('Cursor', 'create');

		_cursors = GameState.phaser().input.keyboard.createCursorKeys();
	}

	/**
	 * Destroy
	 */

	this.destroy = function()
	{
		Console.trace('Cursor', 'destroy');

		_cursors = null;
	};

	/**
	 * Getters
	 */

	this.getPointer = function()
	{
		return IS_MOBILE? GameState.phaser().input.pointer1: GameState.phaser().input.mousePointer;
	};

	this.getWorldPointer = function()
	{
		return { x : game.input.activePointer.worldX, y : game.input.activePointer.worldY };
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

	this.isSpaceBarDown = function()
	{
		return GameState.phaser().input.keyboard.isDown(Phaser.Keyboard.SPACEBAR);
	};
}