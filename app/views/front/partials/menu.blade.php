<button id="user-button" class="interface">User</button>
<button id="menu-button" class="interface">Menu</button>

<div id="menu" class="interface">
	<h1>GameSpace</h1>
	<ul>
		<li id="story-button">Histoire</li>
		<li id="team-button">Equipe</li>
		<li id="contact-button">Contact</li>
		<li id="fullscreen-button">Fullscreen</li>
	</ul>
</div>

<script type="text/javascript">
$(function()
{
	$('#user-button').click(function()
	{
		Interface.showPopup('auth-popup');
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
		if (!_game) return false;

		_game.getGame().stage.scale.startFullScreen();

		_game.getGame().stage.scaleMode = Phaser.StageScaleMode.SHOW_ALL;
		_game.getGame().stage.scale.setShowAll();
		_game.getGame().stage.scale.refresh();
	});
});
</script>