<div id="create-popup" class="popup-mini popup">
	<h2>Création de ma carte</h2>

	<form id="create-form" class="popup-content">
		{{ Form::text('title', '', array('placeholder' => 'Titre')); }}<br>

		<div class="select-style"> 
			{{ Form::select('type', Map::types()); }}
		</div><br>

		{{ Form::text('width',	'', array('placeholder' => 'Nombre de case en largueur')); }}<br>
		{{ Form::text('height', '', array('placeholder' => 'Nombre de case en hauteur')); }}<br>

		{{ Form::textarea('description', '', array('rows' => 2, 'placeholder' => 'Description')); }}<br>

		<input type="hidden" name="datas">

		{{ Form::button('Créer ma carte'); }}
	</form>
</div>

<script>
$(function()
{
	$('#create-form button').click(function()
	{
		API.post_map({
			element_id	: this,
			form_id		: 'create-form'
		});
	});
});
</script>