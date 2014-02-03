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

    {{ HTML::script('js/classes/GameState.js') }}
    {{ HTML::script('js/classes/Console.js') }}
    {{ HTML::script('js/classes/Common.js') }}
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

    {{ HTML::script('js/classes/main-game/Game.js') }}
    {{ HTML::script('js/classes/main-game/Map.js') }}
    {{ HTML::script('js/classes/main-game/Dragon.js') }}
    {{ HTML::script('js/classes/main-game/player/Player.js') }}
    {{ HTML::script('js/classes/main-game/player/Fires.js') }}

    <script type="text/javascript">

        /**
         * Init
         */

        Common.main_game = {
            id      : {{ $game_main->id }},
            images  : {
                map         : '{{ asset('images/main-game/map.png') }}',
                level       : '{{ asset('images/main-game/level.png') }}',
                mini_game   : '{{ asset('images/main-game/mini-game.png') }}',
                dragon      : '{{ asset('images/main-game/dragon.png') }}',
                player      : {
                    player  : '{{ asset('images/main-game/player/player.png') }}',
                    fire    : '{{ asset('images/main-game/player/fire.png') }}'
                }
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
     * Launch
     */

    GameState.launchMainGame();

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