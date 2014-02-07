Validators.Map = function()
{
	this.create = function(form_id)
	{
		if (Security.empty($('#' + form_id + ' input[name=title]').val()))
		{
			Message.error('Le titre est obligatoire.');
			return false;
		}

		if (!Security.integer($('#' + form_id + ' input[name=width]').val()))
		{
			Message.error('La largueur de la carte doit être un nombre.');
			return false;
		}

		if (!Security.integer($('#' + form_id + ' input[name=height]').val()))
		{
			Message.error('La hauteur de la carte doit être un nombre.');
			return false;
		}

		if (!Security.integerInterval($('#' + form_id + ' input[name=width]').val(), 10, 500))
		{
			Message.error('La largueur de la carte doit être comprise entre 10 et 500.');
			return false;
		}

		if (!Security.integerInterval($('#' + form_id + ' input[name=height]').val(), 10, 500))
		{
			Message.error('La hauteur de la carte doit être comprise entre 10 et 500.');
			return false;
		}

		return true;
	};

	this.edit = function(form_id)
	{
		Console.debug(form_id);
		if (Security.empty($('#' + form_id + ' input[name=title]').val()))
		{
			Message.error('Le titre est obligatoire.');
			return false;
		}

		return true;
	};
};

var MapValidator = new Validators.Map;