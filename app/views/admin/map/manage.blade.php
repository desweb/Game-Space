<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Générateur de carte</title>

    {{ HTML::style('css/base.css') }}
    {{ HTML::style('css/map-manage.css') }}

    {{ HTML::script('http://code.jquery.com/jquery-latest.min.js') }}
    {{ HTML::script('js/phaser.min.js') }}

    {{ HTML::script('js/classes/Message.js') }}
    {{ HTML::script('js/classes/API.js') }}
    {{ HTML::script('js/classes/Security.js') }}
</head>
<body>
<div id="create-form">
    <input name="title" placeholder="Titre"/>
    <input name="map-width" placeholder="Nombre de case en largueur"/>
    <input name="map-height" placeholder="Nombre de case en hauteur"/>
    <textarea name="description" placeholder="Description"></textarea>
    <button>Créer ma carte</button>
</div>

<div id="infos"></div>

<div id="game"></div>
<script type="text/javascript">
$(function()
{
    var game;
    var map;
    var tileset;
    var layer;

    var marker;
    var currentTile = 0;

    function launchGame()
    {
        game = new Phaser.Game(800, 600, Phaser.CANVAS, 'game', { preload:preload, create:create, update:update });
    }

    function preload()
    {
        game.load.tilemap('desert', '{{ asset('js/default-map.json') }}', null, Phaser.Tilemap.TILED_JSON);
        game.load.tileset('tiles', '{{ asset('images/tiles.png') }}', 32, 32, -1, 1, 1);
    }

    function create()
    {
        map = game.add.tilemap('desert');

        tileset = game.add.tileset('tiles');
        
        layer = game.add.tilemapLayer(10, 10, 800, 600, tileset, map, 0);

        layer.resizeWorld();

        marker = game.add.graphics();
        marker.lineStyle(2, 0x000000, 1);
        marker.drawRect(0, 0, 32, 32);
    }

    function update()
    {
        marker.x = layer.getTileX(game.input.activePointer.worldX) * 32;
        marker.y = layer.getTileY(game.input.activePointer.worldY) * 32;

        if (game.input.mousePointer.isDown)
        {
            if (game.input.keyboard.isDown(Phaser.Keyboard.SHIFT))
            {
                currentTile = map.getTile(layer.getTileX(marker.x), layer.getTileY(marker.y));
            }
            else
            {
                if (map.getTile(layer.getTileX(marker.x), layer.getTileY(marker.y)) != currentTile)
                {
                    map.putTile(currentTile, layer.getTileX(marker.x), layer.getTileY(marker.y))
                }
            }
        }
    }

    /**
     * Events
     */

    $('#create-form button').click(function(e)
    {
        if (!$('#create-form input[name=title]').val())
        {
            Message.error('Le titre est obligatoire.');
            return false;
        }

        if (!Security.integer($('#create-form input[name=map-width]').val()))
        {
            Message.error('La largueur de la carte doit être un nombre.');
            return false;
        }

        if (!Security.integer($('#create-form input[name=map-height]').val()))
        {
            Message.error('La hauteur de la carte doit être un nombre.');
            return false;
        }
    });

    /**
     * Functionnalities
     */

    function displayInfos(content)
    {
        $('#infos').html(content);

        $('#infos').fadeIn();

        setTimeout(function()
        {
            $('#infos').fadeOut();
        }, 3000);
    }

     /**
      * API
      */

    function apiPostMain()
    {
        // Init
        var game_ids_param  = new Array();
        var games_param     = new Array();
        var game_main_json  = new Array();

        // Main game
        for (var i in level_sprites)
            game_main_json[i] = { pos : { x : level_sprites[i].x, y : level_sprites[i].y }};

        games_param[level_datas.id] = JSON.stringify(game_main_json);

        // Minis games
        for (var i in game_sprites)
            games_param[game_datas[i].id] = JSON.stringify({ pos : { x : game_sprites[i].x, y : game_sprites[i].y }});

        // Request
        $.post('http://game-space.desweb-creation.fr/api/map/main',
            {
                'games[]' : games_param
            },
            function(response)
            {
                displayInfos(response.error? '<span class="error">' + response.error.description + '</span>': '<span class="success">Carte sauvegardée</span>');
            }, 'json')
            .fail(function()
            {
                displayInfos('<span class="error">Une erreur est survenue</span>');
            })
            .always(function()
            {
                is_save = false;

                $('#save-button').html('Sauvegarder');
            });
    }


    /**
     * Debug
     */

    function render()
    {
    }
});
</script>
</body>
</html>