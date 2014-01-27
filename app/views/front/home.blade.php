<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>GameSpace</title>

    {{ HTML::style('css/front.css') }}

    {{ HTML::script('http://code.jquery.com/jquery-latest.min.js') }}
    {{ HTML::script('js/mobile.js') }}
    {{ HTML::script('js/phaser.min.js') }}

    {{ HTML::script('js/classes/Console.js') }}
    {{ HTML::script('js/classes/API.js') }}
    {{ HTML::script('js/classes/Interface.js') }}
    {{ HTML::script('js/classes/Message.js') }}
    {{ HTML::script('js/classes/Font.js') }}
    {{ HTML::script('js/classes/Cursor.js') }}

    {{ HTML::script('js/classes/GameMain.js') }}
</head>
<body>

<div id="mask">
    
</div>

@include('front.partials.menu')

<script type="text/javascript">
$(function()
{
    /**
     * Init
     */

    var _images = {
        map         : '{{ asset('images/map.png') }}',
        level       : '{{ asset('images/phaser.png') }}',
        game_mini   : '{{ asset('images/phaser.png') }}'
    };

    var _game_main_datas = {
        id      : {{ $game_main->id }},
        levels  : {{ $game_main->datas }}
    };

    var _game_datas  = [
        @foreach($games as $game)
            {
                id      : {{ $game->id }},
                datas   : {{ $game->datas }},
                title   : "{{ $game->title }}"
            },
        @endforeach
    ];

    var _game_main;

    /**
     * Main game
     */

    _game_main = new GameMain;

    _game_main.init({
        images          : _images,
        game_main_datas : _game_main_datas,
        game_datas      : _game_datas
    });

    _game_main.launch();

    /**
     * Events
     */

    $('#menu-button').click(function(e)
    {
        var animation = { left : ($('#menu').position().left == 0? '-': '+') + '=200' };

        $('#menu')          .animate(animation, 1000);
        $('#menu-button')   .animate(animation, 1000);
    });
});
</script>

@include('front.universal-analytics')
</body>
</html>