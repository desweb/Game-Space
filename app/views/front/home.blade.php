<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>GameSpace</title>

    <style type="text/css">
        body { padding:0; margin:0; background-color:black; }

        #loading { position:fixed; margin:auto; width:100%; height:100%; background-color:rgba(0, 0, 0, .5); font:20px Arial, sans-serif; color:white; text-align:center; }

        #menu-button { position:absolute; top:10px; left:10px; width:100px; height:50px; background-color:rgba(0, 0, 0, .5); z-index:999; }
        #menu-button:hover { cursor:pointer; }
        #menu { position:absolute; left:-200px; width:200px; height:100%; background-color:black; z-index:999; }

        #fullscreen-button { position:absolute; top:10px; right:10px; width:100px; height:50px; background-color:rgba(0, 0, 0, .5); z-index:999; }
        #fullscreen-button:hover { cursor:pointer; }

        #game { z-index:1; }
    </style>

    {{ HTML::script('http://code.jquery.com/jquery-latest.min.js') }}
    {{ HTML::script('js/phaser.min.js') }}
</head>
<body>
<div id="loading">
    <p>Chargement...</p>
</div>

<div id="menu-button"></div>
<div id="menu"></div>

<div id="fullscreen-button"></div>

<div id="game"></div>
<script type="text/javascript">
$(function()
{
    /**
     * Init
     */

    var game = new Phaser.Game($(window).width(), $(window).height(), Phaser.CANVAS, 'game', { preload:preload, create:create, update:update });

    var player;
    var cursors;

    var default_style = { font:'65px Arial', fill:'#ff0044', align:'center' };

    var level_datas = [
        {
            pos : { top : 800, left : 900 }
        },
        {
            pos : { top : 700, left : 500 }
        }
    ];

    var game_datas = [
        {
            pos : { top : 250, left : 600 }
        },
        {
            pos : { top : 300, left : 200 }
        }
    ];

    /**
     * Loading
     */

    function preload()
    {
        game.load.image('background',   '{{ asset('images/map.png') }}');
        game.load.image('player',       '{{ asset('images/phaser.png') }}');
        game.load.image('level',        '{{ asset('images/phaser.png') }}');
        game.load.image('game-mini',    '{{ asset('images/phaser.png') }}');
    }

    function hideLoader()
    {
        $('#loading').fadeOut(1000, function()
        {
            $('#loading').remove();
        });
    }

    /**
     * Creation
     */

    function create()
    {
        game.add.tileSprite(0, 0, 4000, 4000, 'background');

        game.world.setBounds(0, 0, 4000, 4000);

        level_datas.forEach(function(level_data)
        {
            var level = game.add.sprite(level_data.pos.left, level_data.pos.top, 'level');
            level.scale.setTo(.1, .1);
        });

        game_datas.forEach(function(level_data)
        {
            var game_mini = game.add.sprite(level_data.pos.left, level_data.pos.top, 'game-mini');
            game_mini.scale.setTo(.1, .1);
        });

        player = game.add.sprite(1400, 1400, 'player');
        player.scale.setTo(.2, .2);

        cursors = game.input.keyboard.createCursorKeys();

        game.camera.follow(player);

        hideLoader();
    }

    function update()
    {
        player.body.velocity.setTo(0, 0);

        if      (cursors.up.isDown)     player.body.velocity.y = -200;
        else if (cursors.down.isDown)   player.body.velocity.y = 200;

        if      (cursors.left.isDown)   player.body.velocity.x = -200;
        else if (cursors.right.isDown)  player.body.velocity.x = 200;
    }

    /**
     * Events
     */

    $('#menu-button').click(function(e)
    {
        var animation = { left : ($('#menu').position().left == 0? '-': '+') + '=200' };

        $('#menu')          .animate(animation, 1000);
        $('#menu-button')   .animate(animation, 1000);
    });

    $('#fullscreen-button').click(function(e)
    {
        game.stage.scale.startFullScreen();

        game.stage.scaleMode = Phaser.StageScaleMode.SHOW_ALL; //resize your window to see the stage resize too
game.stage.scale.setShowAll();
game.stage.scale.refresh();
    });

    /**
     * Debug
     */

    function render()
    {
        game.debug.renderCameraInfo(game.camera, 32, 32);
        game.debug.renderSpriteCoords(player, 32, 200);
    }
});
</script>

@include('front.universal-analytics')
</body>
</html>