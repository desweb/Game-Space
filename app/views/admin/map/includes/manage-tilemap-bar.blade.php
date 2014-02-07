<div id="tilemap-container" class="interface">
	<div id="tilemap-content">
		<div class="select-tilemap selected-tilemap" id="select-tilemap-1" data-id="1"></div>
		<div class="select-tilemap" id="select-tilemap-2" data-id="2"></div>
		<div class="select-tilemap" id="select-tilemap-3" data-id="3"></div>
	</div>
</div>

<script>
$(function()
{
	$('.select-tilemap').click(function()
	{
		GameState.game().setCurrentTile($(this).data('id'));

		$('.select-tilemap').removeClass('selected-tilemap');
		$(this).addClass('selected-tilemap');
	});
});
</script>