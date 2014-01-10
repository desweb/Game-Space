<html lang="fr">
  <head>
    <meta charset="UTF-8">

    <title>Administration</title>

    <meta name="msapplication-TileColor" content="#5bc0de">
    <meta name="msapplication-TileImage" content="admin/assets/img/metis-tile.png">

    {{ HTML::style('admin/assets/lib/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('admin/assets/css/main.css') }}
    {{ HTML::style('admin/assets/lib/magic/magic.css') }}
  </head>
  <body class="login" style="">
    <div class="container">
      <div class="text-center">
        <img src="admin/assets/img/logo.png" alt="Metis Logo">
      </div>

      <br>
      @include('admin.partials.message')

      <div class="tab-content">
        @yield('tab-content')
      </div>
    </div>

    {{ HTML::script('admin/assets/lib/jquery.min.js') }}
    {{ HTML::script('admin/assets/lib/bootstrap/js/bootstrap.min.js') }}

    <script type="text/javascript">
      $('.list-inline li > a').click(function()
      {
        var activeForm = $(this).attr('href') + ' > form';

        $(activeForm).addClass('magictime swap');

        setTimeout(function()
        {
          $(activeForm).removeClass('magictime swap');
        }, 1000);
      });
    </script>
  </body>
</html>