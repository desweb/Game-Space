<!doctype html>
<html>
<head>
    <meta charset="utf-8">

    <title>GameSpace</title>

    {{ HTML::style('http://fonts.googleapis.com/css?family=Kite+One') }}

    {{ HTML::style('global/css/main.css') }}
    {{ HTML::style('game/main.css') }}

    {{ HTML::script('http://code.jquery.com/jquery-latest.min.js') }}
    {{ HTML::script('global/js/libs/jquery.md5.js') }}
    {{ HTML::script('global/js/libs/is-mobile.js') }}
    {{ HTML::script('global/js/libs/phaser.min.js') }}

    {{ HTML::script('global/js/main.js') }}

    {{ HTML::script('global/js/classes/Console.js') }}
    {{ HTML::script('global/js/classes/Font.js') }}
    {{ HTML::script('global/js/classes/Interface.js') }}
    {{ HTML::script('global/js/classes/Message.js') }}
    {{ HTML::script('global/js/classes/Security.js') }}
    {{ HTML::script('global/js/classes/Tools.js') }}

    {{ HTML::script('game/_namespace.js') }}

    {{ HTML::script('game/GameState.js') }}
    {{ HTML::script('game/Common.js') }}
    {{ HTML::script('game/API.js') }}
    {{ HTML::script('game/Cursor.js') }}
    {{ HTML::script('game/User.js') }}

    {{ HTML::script('game/validators/ContactValidator.js') }}

    {{ HTML::script('game/main-game/Game.js') }}
    {{ HTML::script('game/main-game/Map.js') }}
    {{ HTML::script('game/main-game/Dragon.js') }}
    {{ HTML::script('game/main-game/player/Player.js') }}
    {{ HTML::script('game/main-game/player/Fires.js') }}

    <script>

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

<script>
$(function()
{
    /**
     * Launch
     */

    GameState.launchMainGame();
});
</script>

@include('front.universal-analytics')
</body>
</html>