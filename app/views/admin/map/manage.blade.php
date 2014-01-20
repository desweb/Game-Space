<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Générateur de carte</title>

    {{ HTML::style('css/base.css') }}
    {{ HTML::style('css/map-manage.css') }}

    {{ HTML::script('http://code.jquery.com/jquery-latest.min.js') }}
    {{ HTML::script('js/phaser.min.js') }}

    {{ HTML::script('js/classes/API.js') }}
    {{ HTML::script('js/classes/Security.js') }}
    {{ HTML::script('js/classes/Interface.js') }}
    {{ HTML::script('js/classes/Message.js') }}
    {{ HTML::script('js/classes/Map.js') }}

    {{ HTML::script('js/default-map.js') }}
</head>
<body>

@if (!isset($map))
    <div id="create-form" class="form">
        <input name="title" placeholder="Titre"/>
        <input name="map-width" placeholder="Nombre de case en largueur"/>
        <input name="map-height" placeholder="Nombre de case en hauteur"/>
        <textarea name="description" placeholder="Description"></textarea>
        <button>Créer ma carte</button>
    </div>
@endif

<div id="edit-form" class="form">
    <input name="title" placeholder="Titre"/>
    <textarea name="description" placeholder="Description"></textarea>
    <button>Enregistrer</button>
</div>

<div id="tools" class="interface">
    <div class="select-tilemap" id="select-tilemap-1" data-id="1"></div>
    <div class="select-tilemap" id="select-tilemap-2" data-id="2"></div>
    <div class="select-tilemap" id="select-tilemap-3" data-id="3"></div>
</div>

<div id="edit-button" class="button interface">Editer informations</div>
<div id="save-button" class="button interface">Sauvegarder</div>

<script type="text/javascript">
$(function()
{
    /**
     * Init
     */

    var game;
    var map;
    var tileset;
    var layer;

    var tilemap_datas = default_map;
    var map_object = new Map;

    var is_save = false;

    var marker;
    var current_tile = 1;

    @if (isset($map))
        map_object.setId            ({{ $map->id }});
        map_object.setTitle         ("{{ $map->title }}");
        map_object.setDescription   ("{{ $map->description }}");
        map_object.setTilemap       ({{ $map->datas }});

        launchGame();
    @else
        $('#create-form').fadeIn();
    @endif

    function launchGame()
    {
        Interface.loading();

        game = new Phaser.Game(map_object.getTilemap().width * 32, map_object.getTilemap().height * 32, Phaser.CANVAS, Interface.getGameId(), { preload:preload, create:create, update:update, render:render });
    }

    function preload()
    {
        game.load.tilemap('desert', map_object.getTilemapUrl(), null, Phaser.Tilemap.TILED_JSON);
        game.load.tileset('tiles', '{{ asset('images/tiles.png') }}', 32, 32, -1, 1, 1);
    }

    function create()
    {
        map = game.add.tilemap('desert');

        tileset = game.add.tileset('tiles');
        
        layer = game.add.tilemapLayer(10, 10, map_object.getTilemap().width * 32, map_object.getTilemap().height * 32, tileset, map, 0);

        marker = game.add.graphics();
        marker.lineStyle(2, 0x000000, 1);
        marker.drawRect(0, 0, 32, 32);

        // Display game
        Interface.show(true, function()
        {
            Message.info('Sélectionnez la texture et cliquez sur la carte.');
        });
    }

    function update()
    {
        marker.x = layer.getTileX(game.input.activePointer.worldX) * 32;
        marker.y = layer.getTileY(game.input.activePointer.worldY) * 32;

        if (!game.input.mousePointer.isDown) return;

        if (map.getTile(layer.getTileX(marker.x), layer.getTileY(marker.y)) != current_tile)
        {
            map.putTile(current_tile, layer.getTileX(marker.x), layer.getTileY(marker.y));

            var index = layer.getTileY(marker.y) * map_object.getTilemap().width + layer.getTileX(marker.x);

            map_object.getTilemap().layers[0].data[index] = current_tile;
        }
    }

    /**
     * Events
     */

    @if (!isset($map))
        $('#create-form button').click(function(e)
        {
            if (is_save) return false;

            is_save = true;

            if (!map_object.checkCreateForm({
                    title   : $('#create-form input[name=title]')       .val(),
                    width   : $('#create-form input[name=map-width]')   .val(),
                    height  : $('#create-form input[name=map-height]')  .val()
                })) return false;

            $(this).html('Chargement...');

            map_object.setTitle         ($('#create-form input[name=title]')            .val());
            map_object.setDescription   ($('#create-form textarea[name=description]')   .val());

            map_object.setSize($('#create-form input[name=map-width]').val(), $('#create-form input[name=map-height]').val());

            map_object.save({
                success : function(response)
                {
                    if (response.error) return;

                    $('#create-form').fadeOut(1000, function()
                    {
                        $('#create-form').remove();
                        launchGame();
                    });
                },
                fail : function()
                {

                },
                always : function()
                {
                    $('#create-form button').html('Créer ma carte');

                    is_save = false;
                }
            });
        });
    @endif

    $('#edit-button').click(function(e)
    {
        $('#edit-form').fadeToggle();

        $('#edit-form input[name=title]')           .val(map_object.getTitle);
        $('#edit-form textarea[name=description]')  .val(map_object.getDescription);
    });

    $('#edit-form button').click(function(e)
    {
        if (is_save) return false;

        is_save = true;

        if (!map_object.checkEditForm({
                title : $('#edit-form input[name=title]').val()
            })) return false;

        $(this).html('Chargement...');

        map_object.setTitle         ($('#edit-form input[name=title]')          .val());
        map_object.setDescription   ($('#edit-form textarea[name=description]') .val());

        map_object.save({
            success : function(response)
            {
                if (response.error) return;

                $('#edit-form').fadeOut();

                Message.success('Carte sauvegardée');
            },
            fail : function()
            {

            },
            always : function()
            {
                $('#edit-form button').html('Enregistrer');

                is_save = false;
            }
        });
    });

    $('.select-tilemap').click(function(e)
    {
        current_tile = $(this).data('id');
    });

    $('#save-button').click(function(e)
    {
        if (is_save) return false;

        is_save = true;

        $(this).html('Chargement...');

        map_object.save({
            success : function(response)
            {
                if (response.error) return;

                Message.success('Carte sauvegardée');
            },
            fail : function()
            {

            },
            always : function()
            {
                $('#save-button').html('Sauvegarder');

                is_save = false;
            }
        });
    });

    /**
     * Functionnalities
     */

    /**
     * Debug
     */

    function render()
    {
        //game.debug.renderSpriteInfo(player, 32, 200);
    }
});
</script>
</body>
</html>