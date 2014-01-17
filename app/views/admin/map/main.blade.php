<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Gestion de la carte principale</title>

    <style type="text/css">
        body { padding:0; margin:0; background-color:black; }

        #loading { position:fixed; margin:auto; width:100%; height:100%; background-color:rgba(0, 0, 0, .5); font:20px Arial, sans-serif; color:white; text-align:center; }

        #save-button { position:absolute; top:10px; right:10px; padding:10px 20px; background-color:rgba(0, 0, 0, .5); border-radius:3px; font:bold 15px Arial, sans-serif; color:white; }
        #save-button:hover { cursor:pointer; }

        #infos { position:absolute; top:10px; right:150px; padding:10px 20px; background-color:rgba(0, 0, 0, .5); border-radius:3px; font:bold 15px Arial, sans-serif; display:none; }
        #infos .error	{ color:red; }
        #infos .success	{ color:green; }
    </style>

    {{ HTML::script('http://code.jquery.com/jquery-latest.min.js') }}
    {{ HTML::script('js/phaser.min.js') }}
</head>
<body>
<div id="loading">
    <p>Chargement...</p>
</div>

<div id="save-button">Sauvegarder</div>

<div id="infos"></div>

<div id="game"></div>
<script type="text/javascript">
$(function()
{
    /**
     * Init
     */

    var game = new Phaser.Game($(window).width(), $(window).height(), Phaser.CANVAS, 'game', { preload:preload, create:create, update:update });

    var is_save = false;

    var player;
    var cursors;

    var default_style = { font:'15px Arial', fill:'#fff', align:'center' };

    var level_texts		= new Array();
    var level_sprites	= new Array();
    var level_datas		= {
    	id		: {{ $game_main->id }},
    	datas	: {{ $game_main->datas }}
    };

    var game_texts		= new Array();
    var game_sprites	= new Array();
    var game_datas		= [
        @foreach($games as $game)
        	{
    			id		: {{ $game->id }},
        		datas	: {{ $game->datas }},
        		title	: '{{ $game->title }}'
        	},
        @endforeach
    ];

    /**
     * Loading
     */

    function preload()
    {
        game.load.image('background',   '{{ asset('images/map.png') }}');
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

    	for (var i in level_datas.datas)
    	{
            level_sprites[i] = game.add.sprite(level_datas.datas[i].pos.x, level_datas.datas[i].pos.y, 'level');
    		level_sprites[i].anchor.setTo(.5, .5);
            level_sprites[i].scale.setTo(.1, .1);
            level_sprites[i].inputEnabled = true;
            level_sprites[i].input.enableDrag(true);

    		level_texts[i] = game.add.text(level_sprites[i].x, level_sprites[i].y, 'Jeu principal - Niveau ' + (parseInt(i) + 1), default_style);
    		level_texts[i].anchor.setTo(.5, 2);
    	}

    	for (var i in game_datas)
    	{
            game_sprites[i] = game.add.sprite(game_datas[i].datas.pos.x, game_datas[i].datas.pos.y, 'game-mini');
    		game_sprites[i].anchor.setTo(.5, .5);
            game_sprites[i].scale.setTo(.1, .1);
            game_sprites[i].inputEnabled = true;
            game_sprites[i].input.enableDrag(true);

    		game_texts[i] = game.add.text(game_sprites[i].x, game_sprites[i].y, game_datas[i].title, default_style);
    		game_texts[i].anchor.setTo(.5, 2);
    	}

        player = game.add.sprite(0, 0);

        cursors = game.input.keyboard.createCursorKeys();

        game.camera.follow(player);

        hideLoader();
    }

    function update()
    {
    	for (var i in level_sprites)
    	{
    		level_texts[i].x = level_sprites[i].x;
    		level_texts[i].y = level_sprites[i].y;
    	}

    	for (var i in game_sprites)
    	{
    		game_texts[i].x = game_sprites[i].x;
    		game_texts[i].y = game_sprites[i].y;
    	}

        player.body.velocity.setTo(0, 0);

        if      (cursors.up.isDown)     player.body.velocity.y = -200;
        else if (cursors.down.isDown)   player.body.velocity.y = 200;

        if      (cursors.left.isDown)   player.body.velocity.x = -200;
        else if (cursors.right.isDown)  player.body.velocity.x = 200;
    }

    /**
     * Events
     */

	$('#save-button').click(function(e)
	{
		if (is_save) return false;

		is_save = true;

		$(this).html('Chargement...');

		apiPostMain();
	});

     /**
      * API
      */

	function apiPostMain()
	{
		$.post('http://game-space.desweb-creation.fr/api/map/main',
			{ test : 'test' },
			function(response)
			{
				response = JSON.parse(response);

				$('#infos').html(response.error? '<span class="error">' + response.description + '</span>': '<span class="success">Carte sauvegardée</span>');
				$('#infos').fadeIn();

				$('#save-button').html('Sauvegarder');
				is_save = false;

				setTimeout(function()
				{
					$('#infos').fadeOut();
				}, 3000);
			},
			'json');
	}

    /**
     * Debug
     */

    function render()
    {
        game.debug.renderCameraInfo(game.camera, 32, 32);
    }
});
</script>

@include('front.universal-analytics')
</body>
</html>