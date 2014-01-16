<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>GameSpace</title>

        <style type="text/css">
            body { padding:0; margin:0; background-color:black; }

            #game { margin:auto; width:1200px; height:800px; }
        </style>

        {{ HTML::script('js/phaser.min.js') }}
    </head>
    <body>
        <div id="game"></div>
        <script type="text/javascript">
        (function()
        {
            var game = new Phaser.Game(1200, 800, Phaser.CANVAS, 'game', { preload:preload, create:create, update:update, render:render });

            function preload()
            {
                game.load.image('background',   '{{ asset('images/map.png') }}');
                game.load.image('player',       '{{ asset('images/phaser.png') }}');
            }

            var player;
            var cursors;

            function create()
            {
                game.add.tileSprite(0, 0, 2000, 2000, 'background');

                game.world.setBounds(0, 0, 1500, 1500);

                player = game.add.sprite(150, 320, 'player');
                player.scale.setTo(.2, .2);

                cursors = game.input.keyboard.createCursorKeys();

                game.camera.follow(player);

                game.input.onDown.add(clickGame, this);
            }

            function update()
            {
                player.body.velocity.setTo(0, 0);

                if      (cursors.up.isDown)     player.body.velocity.y = -200;
                else if (cursors.down.isDown)   player.body.velocity.y = 200;

                if      (cursors.left.isDown)   player.body.velocity.x = -200;
                else if (cursors.right.isDown)  player.body.velocity.x = 200;
            }

            function render()
            {
                game.debug.renderCameraInfo(game.camera, 32, 32);
                game.debug.renderSpriteCoords(player, 32, 200);
            }

            function clickGame()
            {
                game.stage.scale.startFullScreen();
            }
        })();
        </script>
    </body>
</html>