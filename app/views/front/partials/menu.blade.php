<button id="user-button" class="interface">User</button>
<button id="menu-button" class="interface"></button>

<div id="menu" class="interface">
	<h1>GameSpace</h1>

	<p id="story-button">Histoire</p>
	<p id="team-button">Equipe</p>
	<p id="contact-button">Contact</p>
	<p id="fullscreen-button">Fullscreen</p>
</div>

<script type="text/javascript">
$(function()
{
	$('#user-button').click(function()
	{
		Interface.showPopup((User.isConnected()? 'user': 'auth') + '-popup');
	});

	$('#menu-button').click(function()
	{
		if ($('#menu').position().left == 0)
		{
			$('#menu-button')	.animate({ left : '-=200' },				500);
			$('#menu')			.animate({ left : '-=200', opacity : 0 },	500);
		}
		else
		{
			$('#menu-button')	.animate({ left : '+=200' },				500);
			$('#menu')			.animate({ left : '+=200', opacity : 1 },	500);
		}
	});

	$('#story-button').click(function()
	{
		Interface.showPopup('story-popup');
	});

	$('#team-button').click(function()
	{
		Interface.showPopup('team-popup');
	});

	$('#contact-button').click(function()
	{
		Interface.showPopup('contact-popup');
	});

	$('#fullscreen-button').click(function()
	{
		if (!GameState.phaser()) return false;

		GameState.phaser().stage.scale.startFullScreen();

		GameState.phaser().stage.scaleMode = Phaser.StageScaleMode.SHOW_ALL;
		GameState.phaser().stage.scale.setShowAll();
		GameState.phaser().stage.scale.refresh();
	});
});
</script>