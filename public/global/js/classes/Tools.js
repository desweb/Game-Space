function Tools()
{
	this.previewImage = function(element_id, input)
	{
		if (!input.files || !input.files[0]) return;

		var element = $('img#' + element_id);

		var reader = new FileReader();

		reader.onload = function(e)
		{
			element.attr('src', e.target.result);
			element.fadeIn();
		};

		reader.readAsDataURL(input.files[0]);
	};

	this.destroySprite = function(sprite)
	{
		if (sprite.parent)	sprite.parent.removeChild(sprite);
		if (sprite.input)	sprite.input.destroy();

		sprite.destroy();
		sprite = null;
	};
}

var Tools = new Tools;