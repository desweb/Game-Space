function Cursor(phaser)
{
	Console.trace('Cursor', 'constructor');

	var _phaser = phaser;
	var _cursors;

	create();

	/**
	 * Create
	 */

	function create()
	{
		Console.trace('Cursor', 'create');

		_cursors = _phaser.input.keyboard.createCursorKeys();
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
		return IS_MOBILE? _phaser.input.pointer1: _phaser.input.mousePointer;
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
		return IS_MOBILE? _phaser.input.pointer1.isDown: _phaser.input.mousePointer.isDown;
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
		return _phaser.input.keyboard.isDown(Phaser.Keyboard.SPACEBAR);
	};
}