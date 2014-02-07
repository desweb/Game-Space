Models.Map = function()
{
	Console.trace('Models.Map', 'constructor');

	var _id;
	var _title;
	var _description;

	var _tilemap;

	var _form_id = 'form#edit-form';

	/**
	 * Init
	 */

	this.init = function()
	{
		if (Common.map.id)
		{
			_id			= Common.map.id;
			_title		= Common.map.title;
			_description= Common.map.description;
			_tilemap	= Common.map.tilemap;
		}
		else _tilemap = default_map;
	};

	this.initEditForm = function()
	{
		$(_form_id + ' input[name=title]')			.val(_title);
		$(_form_id + ' textarea[name=description]')	.val(_description);
	};

	/**
	 * Getters
	 */

	this.getId			= function() { return _id; };
	this.getTitle		= function() { return _title; };
	this.getDescription	= function() { return _description; };
	this.getTilemap		= function() { return _tilemap; };

	this.getTilemapUrl = function() { return 'http://admin.game-space.desweb-creation.fr/api/map/' + _id + '/datas'; };

	this.getDownloadUrl = function() { return 'http://admin.game-space.desweb-creation.fr/carte/' + _id + '/telecharger'; };

	/**
	 * Setters
	 */

	this.setId			= function(id)			{ _id 			= id; };
	this.setType		= function(type)		{ _tilemap.tilesets[0].image = type; };
	this.setTitle		= function(title)		{ _title 		= title; };
	this.setDescription	= function(description)	{ _description	= description; };
	this.setTilemap		= function(tilemap)		{ _tilemap		= tilemap; };

	this.setTilemapData = function(index, value) { return _tilemap.layers[0].data[index] = value; };

	this.setSize = function(width, height)
	{
		width		= parseInt(width);
		height		= parseInt(height);

		var total_cases	= width * height;

		_tilemap.width	= width;
		_tilemap.height	= height;
		_tilemap.layers[0].width	= width;
		_tilemap.layers[0].height	= height;

		for (var i = 0; i < total_cases; i++) _tilemap.layers[0].data[i] = 1;
	};
};