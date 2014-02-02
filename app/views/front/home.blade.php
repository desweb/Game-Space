<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>GameSpace</title>

    {{ HTML::style('http://fonts.googleapis.com/css?family=Kite+One') }}

    {{ HTML::style('css/front.css') }}

    {{ HTML::script('http://code.jquery.com/jquery-latest.min.js') }}
    {{ HTML::script('js/jquery.md5.js') }}
    {{ HTML::script('js/mobile.js') }}
    {{ HTML::script('js/phaser.min.js') }}

    {{ HTML::script('js/classes/Console.js') }}
    {{ HTML::script('js/classes/API.js') }}
    {{ HTML::script('js/classes/Tools.js') }}
    {{ HTML::script('js/classes/Interface.js') }}
    {{ HTML::script('js/classes/Message.js') }}
    {{ HTML::script('js/classes/Font.js') }}
    {{ HTML::script('js/classes/Cursor.js') }}
    {{ HTML::script('js/classes/Security.js') }}
    {{ HTML::script('js/classes/Contact.js') }}
    {{ HTML::script('js/classes/User.js') }}

    {{ HTML::script('js/classes/namespace.js') }}

    {{ HTML::script('js/classes/game-main/Game.js') }}
    {{ HTML::script('js/classes/game-main/Map.js') }}
    {{ HTML::script('js/classes/game-main/Player.js') }}
    {{ HTML::script('js/classes/game-main/player/Fires.js') }}
    {{ HTML::script('js/classes/game-main/Dragon.js') }}

    <script type="text/javascript">

        /**
         * Init
         */

        var images = {
            map         : '{{ asset('images/map.png') }}',
            level       : '{{ asset('images/phaser.png') }}',
            game_mini   : '{{ asset('images/phaser.png') }}',
            player_fire : '{{ asset('images/game-main/fire.png') }}'
        };

        var game_main_datas = {
            id      : {{ $game_main->id }},
            levels  : {{ $game_main->datas }}
        };

        var game_datas  = [
            @foreach($games as $game)
                {
                    id      : {{ $game->id }},
                    datas   : {{ $game->datas }},
                    title   : "{{ $game->title }}"
                },
            @endforeach
        ];

        var current_game;

    </script>
</head>
<body>

<div id="mask">
    @if (Session::has('is_password_reinit'))
        @include('front.popups.password-reinit')
    @endif

    @include('front.popups.auth')
    @include('front.popups.user')
    @include('front.popups.story')
    @include('front.popups.team')
    @include('front.popups.contact')
</div>

@include('front.partials.social-networks-share')

@include('front.partials.menu')

<script type="text/javascript">
$(function()
{
    /**
     * Main game
     */

    current_game = new GameMain.Game;

    current_game.init({
        images          : images,
        game_main_datas : game_main_datas,
        game_datas      : game_datas
    });

    current_game.launch();

    /**
     * Events
     */

    /* Popup */

    $('#mask').click(function()
    {
        Interface.hidePopup();
    });

    $('.popup').click(function(e)
    {
        e.stopPropagation();
    });

    $('.popup .close').click(function()
    {
        Interface.hidePopup();
    });

    /* Form */

    $('input[type=file]').change(function()
    {
        if (!$(this).data('preview')) return false;

        Tools.previewImage($(this).data('preview'), this);
    });
});
</script>

@include('front.universal-analytics')
</body>
</html>