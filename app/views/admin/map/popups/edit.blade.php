<div id="edit-popup" class="popup-mini popup">
	<div class="close link"></div>
	<h2>Edition de ma carte</h2>

	<form id="edit-form" class="popup-content">
		{{ Form::text('title', '', array('placeholder' => 'Titre')); }}<br>

		{{ Form::textarea('description', '', array('rows' => 2, 'placeholder' => 'Description')); }}<br>

		<input type="hidden" name="datas">

		{{ Form::button('Enregistrer'); }}
	</form>
</div>

<script>
$(function()
{
	$('#edit-form button').click(function()
	{
		API.post_mapUpdate({
			element_id	: this,
			form_id		: 'edit-form'
		});
	});
});
</script>