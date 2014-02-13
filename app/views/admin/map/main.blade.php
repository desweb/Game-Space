<!doctype html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Gestion de la carte principale</title>

    {{ HTML::style('global/css/main.css') }}
    {{ HTML::style('admin/main-map/main.css') }}

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

    {{ HTML::script('admin/main-map/_namespace.js') }}
    {{ HTML::script('admin/main-map/api.js') }}

    {{ HTML::script('admin/main-map/Common.js') }}
    {{ HTML::script('admin/main-map/Cursor.js') }}
    {{ HTML::script('admin/main-map/GameState.js') }}

    {{ HTML::script('admin/main-map/game/Game.js') }}
    {{ HTML::script('admin/main-map/game/map/Map.js') }}
    {{ HTML::script('admin/main-map/game/map/Level.js') }}
    {{ HTML::script('admin/main-map/game/map/MiniGame.js') }}

    <script>

        /**
         * Init
         */

        Common.game = {
            id      : {{ $game_main->id }},
            images  : {
                map         : '{{ asset('images/main-game/map.png') }}',
                level       : '{{ asset('images/main-game/level.png') }}',
                mini_game   : '{{ asset('images/main-game/mini-game.png') }}'
            },
            levels      : {{ $game_main->datas }},
            mini_games  : [
            @foreach($games as $game)
                {
                    id      : {{ $game->id }},
                    datas   : {{ $game->datas }},
                    title   : "{{ $game->title }}"
                },
            @endforeach
            ]
        };

    </script>
</head>
<body>

<div id="tool-bar" class="interface">
    <div class="right">
        <button id="save-button">Sauvegarder</button>
    </div>
</div>

<script type="text/javascript">
$(function()
{
    /**
     * Launch
     */

    GameState.launchGame();

    /**
     * Events
     */

     // Scroll mouse
    /*game_element.addEventListener('mousewheel', function(e)
    {
        var sens = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));

        // Pending 1.1.4 Phaser framework version to work zoom camera
    }, false);*/

    // Click save button
	$('#save-button').click(function(e)
	{
		API.post_mapMain(this);
	});
});
</script>
</body>
</html>