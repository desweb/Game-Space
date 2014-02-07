Game.Game = function()
{
    Console.trace('Game.Game', 'constructor');

	// Game
	var _game;

	// Cursor : Mouse, Keyboard, touch
	var _cursor;

    // Map
    var _map_tilemap;
    var _map_tileset;
    var _map_layer;

	// Current save
	var _is_unsave = false;

    // Marker on the map
    var _marker;

    // Current tile selected
    var _current_tile = 1;

    launch();

    /**
     * Launch
     */

    function launch()
    {
        Console.trace('Game.Game', 'launch');

        _game = new Phaser.Game(GameState.mapModel().getTilemap().width * 32, GameState.mapModel().getTilemap().height * 32, Phaser.CANVAS, Interface.getGameId(), { preload:preload, create:create, update:update });
    }

    /**
     * Loading
     */

    function preload()
    {
        Console.trace('Game.Game', 'preload');

        _game.load.tilemap('map', GameState.mapModel().getTilemapUrl(), null, Phaser.Tilemap.TILED_JSON);
        _game.load.tileset('map', Common.map.tileset, 32, 32, -1, 1, 1);
    }

    /**
     * Create
     */

    function create()
    {
        Console.trace('Game.Game', 'create');

        // Create map
        _map_tilemap = _game.add.tilemap('map');
        _map_tileset = _game.add.tileset('map');

        _map_layer = _game.add.tilemapLayer(10, 10, GameState.mapModel().getTilemap().width * 32, GameState.mapModel().getTilemap().height * 32, _map_tileset, _map_tilemap, 0);

        // Create marker
        _marker = new Game.Marker;

        // Display game
        Interface.show(true, function()
        {
            Message.info('Sélectionnez la texture et cliquez sur la carte.');
        });

        _cursor = new Cursor(_game, IS_MOBILE);
    }

    /**
     * Update
     */

    function update()
    {
        _marker.update();

        var map_tile = _map_tilemap.getTile(_map_layer.getTileX(_marker.getGraphic().x), _map_layer.getTileY(_marker.getGraphic().y));

        if (!_cursor.isPointerDown() || map_tile === undefined || map_tile == _current_tile) return;

        _is_unsave = true;

        _map_tilemap.putTile(_current_tile, _map_layer.getTileX(_marker.getGraphic().x), _map_layer.getTileY(_marker.getGraphic().y));

        GameState.mapModel().setTilemapData(_map_layer.getTileY(_marker.getGraphic().y) * GameState.mapModel().getTilemap().width + _map_layer.getTileX(_marker.getGraphic().x), _current_tile);
    }

    /**
     * Getters
     */

    this.getGame = function()
    {
        return _game;
    };

    this.getCursor = function()
    {
        return _cursor;
    };

    this.getMapLayer = function()
    {
        return _map_layer;
    }

    /**
     * Setters
     */

    this.setCurrentTile = function(current_tile)
    {
        _current_tile = current_tile;
    };

    this.setIsUnsave = function(is_unsave)
    {
        _is_unsave = is_unsave;
    };

    /**
     * Checks
     */

    this.isUnsave = function()
    {
        return _is_unsave;
    };
};