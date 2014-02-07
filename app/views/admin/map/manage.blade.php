<!doctype html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Générateur de carte</title>

    {{ HTML::style('global/css/main.css') }}
    {{ HTML::style('admin/manage-map/main.css') }}

    {{ HTML::script('http://code.jquery.com/jquery-latest.min.js') }}
    {{ HTML::script('global/js/libs/is-mobile.js') }}
    {{ HTML::script('global/js/libs/phaser.min.js') }}

    {{ HTML::script('global/js/classes/API.js') }}
    {{ HTML::script('global/js/classes/Console.js') }}
    {{ HTML::script('global/js/classes/Font.js') }}
    {{ HTML::script('global/js/classes/Interface.js') }}
    {{ HTML::script('global/js/classes/Message.js') }}
    {{ HTML::script('global/js/classes/Security.js') }}
    {{ HTML::script('global/js/classes/Tools.js') }}

    {{ HTML::script('global/js/main.js') }}

    {{ HTML::script('admin/manage-map/_namespace.js') }}
    {{ HTML::script('admin/manage-map/api.js') }}
    {{ HTML::script('admin/manage-map/default-map.js') }}

    {{ HTML::script('admin/manage-map/models/Map.js') }}

    {{ HTML::script('admin/manage-map/validators/Map.js') }}

    {{ HTML::script('admin/manage-map/Common.js') }}
    {{ HTML::script('admin/manage-map/Cursor.js') }}
    {{ HTML::script('admin/manage-map/GameState.js') }}

    {{ HTML::script('admin/manage-map/game/Game.js') }}
    {{ HTML::script('admin/manage-map/game/Marker.js') }}

    <script>

        /**
         * Init
         */

        Common.map = {
            @if (isset($map))
                id          : {{ $map->id }},
                title       : "{{ $map->title }}",
                description : "{{ $map->description }}",
                tilemap     : {{ $map->datas }},
            @endif

            tileset : '{{ asset('global/tilemaps/desert.png') }}'
        };

        GameState.mapModel().init();
    </script>
</head>
<body>

<div id="mask">
    @if (!isset($map))
        @include('admin.map.popups.create')
    @endif

    @include('admin.map.popups.edit')
</div>

@include('admin.map.includes.manage-tool-bar')
@include('admin.map.includes.manage-tilemap-bar')

<script>
$(function()
{
    /**
     * Launch
     */

    @if (isset($map))
        GameState.launchGame();

        GameState.mapModel().initEditForm();
    @else
        Interface.showPopup('create-popup');
    @endif
});
</script>
</body>
</html>