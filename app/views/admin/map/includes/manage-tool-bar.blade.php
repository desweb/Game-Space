<div id="tool-bar" class="interface">
	<div class="right">
		<button id="edit-button">Editer informations</button>
		<button id="save-button">Sauvegarder</button>
		<button id="download-button">Télécharger</button>
	</div>
</div>

<script>
$(function()
{
	$('#edit-button').click(function()
	{
		Interface.showPopup('edit-popup');

		$('#edit-form input[name=title]')			.val(GameState.mapModel().getTitle());
		$('#edit-form textarea[name=description]')	.val(GameState.mapModel().getDescription());
	});

	$('#save-button').click(function()
	{
		API.post_mapUpdate({
			element_id	: this,
			form_id		: 'edit-form'
		});
	});

	$('#download-button').click(function()
	{
		if (GameState.game().isUnsave() && !confirm('Attention, des modifications n\'ont pas été enregistrées.\nTélécharger quand même ?')) return false;

		location.href = GameState.mapModel().getDownloadUrl();
	});
});
</script>