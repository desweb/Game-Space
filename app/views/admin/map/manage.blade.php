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
        {{ Form::text('title',   '', array('placeholder' => 'Titre')); }}

        <div class="style-select"> 
            {{ Form::select('type', Map::types()); }}
        </div>

        {{ Form::text('width',  '', array('placeholder' => 'Nombre de case en largueur')); }}
        {{ Form::text('height', '', array('placeholder' => 'Nombre de case en hauteur')); }}

        {{ Form::textarea('description', '', array('placeholder' => 'Description')); }}

        {{ Form::button('Créer ma carte'); }}
    </div>
@endif

<div id="edit-form" class="form">
    {{ Form::text('name', '', array('placeholder' => 'Titre')); }}

    {{ Form::textarea('description', '', array('placeholder' => 'Description')); }}

    {{ Form::button('Enregistrer'); }}
</div>

<div id="tool-bar" class="interface">
    <div class="right">
        <div id="edit-button" class="button interface">Editer informations</div>
        <div id="save-button" class="button interface">Sauvegarder</div>
    </div>
</div>
<div id="tilemap-container" class="interface">
    <div id="tilemap-content">
        <div class="select-tilemap selected-tilemap" id="select-tilemap-1" data-id="1"></div>
        <div class="select-tilemap" id="select-tilemap-2" data-id="2"></div>
        <div class="select-tilemap" id="select-tilemap-3" data-id="3"></div>
    </div>
</div>


<script type="text/javascript">
$(function()
{
    /**
     * Init
     */

    var game;

    // Map
    var map_tilemap;
    var map_tileset;
    var map_layer;

    var map_object = new Map;

    var is_save = false;

    var marker_graph;
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

        game = new Phaser.Game(map_object.getTilemap().width * 32, map_object.getTilemap().height * 32, Phaser.CANVAS, Interface.getGameId(), { preload:preload, create:create, update:update });
    }

    function preload()
    {
        game.load.tilemap('map', map_object.getTilemapUrl(), null, Phaser.Tilemap.TILED_JSON);
        game.load.tileset('map', '{{ asset('images/tiles.png') }}', 32, 32, -1, 1, 1);
    }

    function create()
    {
        // Create map
        map_tilemap = game.add.tilemap('map');
        map_tileset = game.add.tileset('map');
        
        map_layer = game.add.tilemapLayer(10, 10, map_object.getTilemap().width * 32, map_object.getTilemap().height * 32, map_tileset, map_tilemap, 0);

        // Create marker
        marker_graph = game.add.graphics();
        marker_graph.lineStyle(2, 0x000000, 1);
        marker_graph.drawRect(0, 0, 32, 32);

        // Display game
        Interface.show(true, function()
        {
            Message.info('Sélectionnez la texture et cliquez sur la carte.');
        });
    }

    function update()
    {
        marker_graph.x = map_layer.getTileX(game.input.activePointer.worldX) * 32;
        marker_graph.y = map_layer.getTileY(game.input.activePointer.worldY) * 32;

        if (!game.input.mousePointer.isDown) return;

        if (map_tilemap.getTile(map_layer.getTileX(marker_graph.x), map_layer.getTileY(marker_graph.y)) != current_tile)
        {
            map_tilemap.putTile(current_tile, map_layer.getTileX(marker_graph.x), map_layer.getTileY(marker_graph.y));

            map_object.getTilemap().layers[0].data[map_layer.getTileY(marker_graph.y) * map_object.getTilemap().width + map_layer.getTileX(marker_graph.x)] = current_tile;
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
                    title   : $('#create-form input[name=title]')   .val(),
                    width   : $('#create-form input[name=width]')   .val(),
                    height  : $('#create-form input[name=height]')  .val()
                })) return false;

            $(this).html('Chargement...');

            map_object.setTitle         ($('#create-form input[name=title]')            .val());
            map_object.setDescription   ($('#create-form textarea[name=description]')   .val());

            map_object.setSize($('#create-form input[name=width]').val(), $('#create-form input[name=height]').val());

            map_object.setType($('#create-form select[name=type]').val());

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

        $('.select-tilemap').removeClass('selected-tilemap');
        $(this).addClass('selected-tilemap');
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

});
</script>
</body>
</html>