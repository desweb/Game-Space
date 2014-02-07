<div id="tool-bar" class="interface">
    <div class="right">
        <button id="save-button">Sauvegarder</button>
    </div>
</div>

<script>
$(function()
{
	$('#save-button').click(function(e)
	{
		API.post_mapMain(this);
	});
});
</script>