<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>hello phaser!</title>
		{{ HTML::script('js/phaser.min.js') }}

		<style type="text/css">
			body { padding:0; margin:0; }
		</style>
	</head>
	<body>
		<script type="text/javascript">
		window.onload = function()
		{
			var game = new Phaser.Game(document.body.offsetWidth, document.body.offsetHeight, Phaser.AUTO, '', { preload:preload, create:create, update:update });

			var logo;

			function preload()
			{
				game.load.image('logo', '{{ asset('images/phaser.png') }}');
			}

			function create()
			{
				logo = game.add.sprite(game.world.centerX, game.world.centerY, 'logo');
				logo.anchor.setTo(0.5, 0.5);
				logo.inputEnabled = true;
				logo.input.enableDrag(true);
			}

			function update()
			{
				//console.log(logo.x + ' - ' + logo.y);
			}
		};
		</script>
	</body>
</html>