<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Gestion de la carte principale</title>

    {{ HTML::style('css/base.css') }}
    {{ HTML::style('css/map-main.css') }}

    {{ HTML::script('http://code.jquery.com/jquery-latest.min.js') }}
    {{ HTML::script('js/phaser.min.js') }}

    {{ HTML::script('js/classes/API.js') }}
    {{ HTML::script('js/classes/Interface.js') }}
    {{ HTML::script('js/classes/Message.js') }}
</head>
<body>

<div id="save-button" class="button interface">Sauvegarder</div>

<script type="text/javascript">
$(function()
{
    /**
     * Init
     */

    Interface.loading();

    var game = new Phaser.Game(4000, 4000, Phaser.CANVAS, Interface.getGameId(), { preload:preload, create:create, update:update });

    var is_save = false;

    var default_style = { font:'15px Arial', fill:'#fff', align:'center' };

    // Main game
    var level_texts		= new Array();
    var level_sprites	= new Array();
    var level_datas		= {
    	id		: {{ $game_main->id }},
    	datas	: {{ $game_main->datas }}
    };

    // Minis games
    var game_texts	= new Array();
    var game_sprites= new Array();
    var game_datas	= [
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

    /**
     * Creation
     */

    function create()
    {
        // World
        game.add.tileSprite(0, 0, 4000, 4000, 'background');

        game.world.setBounds(0, 0, 4000, 4000);

        // Main game
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

        // Minis games
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

        // Display game
        Interface.show(true, function()
        {
            Message.info('Glisser/Déposer les icônes.');
        });
    }

    function update()
    {
        // Main game
    	for (var i in level_sprites)
    	{
    		level_texts[i].x = level_sprites[i].x;
    		level_texts[i].y = level_sprites[i].y;
    	}

        // Minis games
        for (var i in game_sprites)
    	{
    		game_texts[i].x = game_sprites[i].x;
    		game_texts[i].y = game_sprites[i].y;
    	}
    }

    /**
     * Events
     */

    // Click save button
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

    // Override API post_mapMain
    function apiPostMain()
	{
        // Init
        var game_ids_param  = new Array();
        var games_param     = new Array();
        var game_main_json  = new Array();

        // Main game
        for (var i in level_sprites)
            game_main_json[i] = { pos : { x : parseInt(level_sprites[i].x), y : parseInt(level_sprites[i].y) }};

        games_param[level_datas.id] = JSON.stringify(game_main_json);

        // Minis games
        for (var i in game_sprites)
            games_param[game_datas[i].id] = JSON.stringify({ pos : { x : parseInt(game_sprites[i].x), y : parseInt(game_sprites[i].y) }});

        // Request
        API.post_mapMain({
            'games[]' : games_param
        },
        {
            success : function(response)
            {
                if (response.error) return;

                Message.success('Carte sauvegardée');
            },
            always : function()
            {
                is_save = false;

                $('#save-button').html('Sauvegarder');
            }
        });
	}

    /**
     * Functionnalities
     */

});
</script>
</body>
</html>