API.BASE_URL = 'http://admin.game-space.desweb-creation.fr/api/';

API.post_map = function(datas)
{
	if (this.is_loading || !MapValidator.create(datas.form_id)) return;

	this.is_loading = true;

	$(datas.element_id).html(Interface.getLoaderMini());

	GameState.mapModel().setTitle		($('#' + datas.form_id + ' input[name=title]')			.val());
	GameState.mapModel().setDescription	($('#' + datas.form_id + ' textarea[name=description]')	.val());

	GameState.mapModel().setSize($('#' + datas.form_id + ' input[name=width]').val(), $('#' + datas.form_id + ' input[name=height]').val());

	GameState.mapModel().setType($('#' + datas.form_id + ' select[name=type]').val());

	$('#' + datas.form_id + ' input[name=datas]').val(JSON.stringify(GameState.mapModel().getTilemap()));

	this.formRequest({
		url		: 'map',
		form_id	: datas.form_id
	},
	{
		success : function(response)
		{
			if (response.error) return;

			GameState.mapModel().setId(response.id);

			GameState.mapModel().initEditForm();

			Interface.hidePopup(function()
			{
				$('#' + datas.form_id).remove();

				GameState.launchGame();
			});
		},
		always : function()
		{
			$(datas.element_id).html('Créer ma carte');

			API.is_loading = false;
		}
	});
};

API.post_mapUpdate = function(datas)
{
	if (this.is_loading || !MapValidator.edit(datas.form_id)) return;

	this.is_loading = true;

	$(datas.element_id).html(Interface.getLoaderMini());

	GameState.mapModel().setTitle		($('#' + datas.form_id + ' input[name=title]')			.val());
	GameState.mapModel().setDescription	($('#' + datas.form_id + ' textarea[name=description]')	.val());

	$('#' + datas.form_id + ' input[name=datas]').val(JSON.stringify(GameState.mapModel().getTilemap()));

	this.formRequest({
		url		: 'map/' + GameState.mapModel().getId(),
		form_id	: datas.form_id
	},
	{
		success : function(response)
		{
			if (response.error) return;

			GameState.game().setIsUnsave(false);

			Interface.hidePopup();

			Message.success('Carte sauvegardée');
		},
		always : function()
		{
			$(datas.element_id).html('Sauvegarder');

			API.is_loading = false;
		}
	});
};