function Map()
{
	var _id;
	var _title;
	var _description;
	var _tilemap = default_map;

	/**
	 * Functionnalities
	 */

	this.save = function(response_functions)
	{
		if (_id)
		{
			API.post_mapUpdate(_id, {
				title		: _title,
				description	: _description,
				datas		: JSON.stringify(_tilemap)
			},
			{
				success : function(response)
				{
					if (response_functions.success) response_functions.success(response);
				},
				fail : function()
				{
					if (response_functions.fail) response_functions.fail();
				},
				always : function()
				{
					if (response_functions.always) response_functions.always();
				}
			});
		}
		else
		{
			API.post_map({
				title		: _title,
				description	: _description,
				datas		: JSON.stringify(_tilemap)
			},
			{
				success : function(response)
				{
					if (response.id) _id = response.id;

					if (response_functions.success) response_functions.success(response);
				},
				fail : function()
				{
					if (response_functions.fail) response_functions.fail();
				},
				always : function()
				{
					if (response_functions.always) response_functions.always();
				}
			});
		}
	};

	/**
	 * Getters
	 */

	this.getTitle		= function() { return _title; };
	this.getDescription	= function() { return _description; };
	this.getTilemap		= function() { return _tilemap; };

	this.getTilemapUrl	= function() { return 'http://game-space.desweb-creation.fr/api/map/' + _id + '/datas'; };

	this.getDownloadUrl	= function() { return 'http://game-space.desweb-creation.fr/administration/carte/' + _id + '/telecharger'; };

	/**
	 * Setters
	 */

	this.setId			= function(id)			{ _id 			= id; };
	this.setType		= function(type)		{ _tilemap.tilesets[0].image = type; };
	this.setTitle		= function(title)		{ _title 		= title; };
	this.setDescription	= function(description)	{ _description	= description; };
	this.setTilemap		= function(tilemap)		{ _tilemap		= tilemap; };

	this.setSize = function(width, height)
	{
		var width		= parseInt(width);
		var height		= parseInt(height);
		var total_cases	= width * height;

		_tilemap.width	= width;
		_tilemap.height	= height;
		_tilemap.layers[0].width	= width;
		_tilemap.layers[0].height	= height;

		for (var i = 0; i < total_cases; i++)
			_tilemap.layers[0].data[i] = 1;
	};

	/**
	 * Checks
	 */

	this.checkCreateForm = function(datas)
	{
		if (!datas.title)
		{
			Message.error('Le titre est obligatoire.');
			return false;
		}

		if (!Security.integer(datas.width))
		{
			Message.error('La largueur de la carte doit être un nombre.');
			return false;
		}

		if (!Security.integer(datas.height))
		{
			Message.error('La hauteur de la carte doit être un nombre.');
			return false;
		}

		if (datas.width < 10)
		{
			Message.error('La largueur de la carte doit être au minimum de 10.');
			return false;
		}

		if (datas.height < 10)
		{
			Message.error('La hauteur de la carte doit être au minimum de 10.');
			return false;
		}

		return true;
	};

	this.checkEditForm = function(datas)
	{
		if (!datas.title)
		{
			Message.error('Le titre est obligatoire.');
			return false;
		}

		return true;
	};
}