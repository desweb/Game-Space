<div id="top">
  <nav class="navbar navbar-inverse navbar-static-top">
    <header class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a href="{{ route('admin_home') }}" class="navbar-brand">
        {{ HTML::image('admin/assets/img/logo.png', 'Logo') }}
      </a>
    </header>

    <div class="topnav">
      <div class="btn-toolbar">
        <div class="btn-group">
          <a data-placement="bottom" data-original-title="{{ $total_contact_waiting? $total_contact_waiting . ' message' . ($total_contact_waiting > 1? 's': '') . ' reçu' . ($total_contact_waiting > 1? 's': ''): 'Aucun message non lu' }}" data-toggle="tooltip" class="btn btn-default btn-sm">
            <i class="fa fa-envelope"></i>

            @if ($total_contact_waiting)
              <span class="label label-danger">{{ $total_contact_waiting }}</span>
            @endif
          </a>
        </div>

        <div class="btn-group">
          <a data-placement="bottom" data-original-title="Mon profil" href="{{ route('admin_profile') }}" data-toggle="tooltip" class="btn btn-default btn-sm">
            <i class="fa fa-user"></i>
          </a>
        </div>

        <div class="btn-group">
          <a href="{{ route('admin_logout') }}" data-toggle="tooltip" data-original-title="Me déconnecter" data-placement="bottom" class="btn btn-metis-1 btn-sm">
            <i class="fa fa-power-off"></i>
          </a>
        </div>

        <div class="btn-group">
          @foreach (LocaleManager::$langs as $lang)
            <a href="{{ route('lang', array('lang' => $lang)) }}" class="btn btn-default btn-sm">
              {{ $lang }}
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </nav>

  <header class="head">
    <div class="search-bar">
      <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
        <i class="fa fa-expand"></i>
      </a>
      <form method="post" action="{{ route('admin_research') }}" accept-charset="UTF-8" class="main-search">
        <div class="input-group">
          {{ Form::text('research', '', array('class' => 'input-small form-control', 'placeholder' => 'Rechercher', 'required' => true)) }}
          <span class="input-group-btn">
            {{ Form::button('<i class="fa fa-search"></i>', array('type' => 'submit', 'class' => 'btn btn-primary btn-sm text-muted')) }}
          </span>
        </div>
      {{ Form::close() }}
    </div>

    <div class="main-bar">
      <h3>
        @if (Route::currentRouteName() == 'admin_profile')
          <i class="fa fa-user"></i> Mon profil

        @elseif (Route::currentRouteName() == 'admin_home')
          <i class="fa fa-dashboard"></i> Dashboard

        @elseif (Route::currentRouteName() == 'admin_administrator')
          <i class="fa fa-user"></i> Administrateurs
        @elseif (Route::currentRouteName() == 'admin_administrator_add')
          <i class="fa fa-user"></i> Ajouter un administrateur
        @elseif (Route::currentRouteName() == 'admin_administrator_edit')
          <i class="fa fa-user"></i> Editer l'administrateur

        @elseif (Route::currentRouteName() == 'admin_user')
          <i class="fa fa-user"></i> Utilisateurs
        @elseif (Route::currentRouteName() == 'admin_user_edit')
          <i class="fa fa-user"></i> Editer l'utilisateur

        @elseif (Route::currentRouteName() == 'admin_map')
          <i class="fa fa-globe"></i> Cartes

        @elseif (Route::currentRouteName() == 'admin_game')
          <i class="fa fa-bookmark"></i> Jeux
        @elseif (Route::currentRouteName() == 'admin_game_add')
          <i class="fa fa-bookmark"></i> Ajouter un jeu
        @elseif (Route::currentRouteName() == 'admin_game_edit')
          <i class="fa fa-bookmark"></i> Editer le jeu

        @elseif (Route::currentRouteName() == 'admin_achievement')
          <i class="fa fa-star"></i> Trophée
        @elseif (Route::currentRouteName() == 'admin_achievement_add')
          <i class="fa fa-star"></i> Ajouter un trophée
        @elseif (Route::currentRouteName() == 'admin_achievement_edit')
          <i class="fa fa-star"></i> Editer le trophée

        @elseif (Route::currentRouteName() == 'admin_witness')
          <i class="fa fa-comment"></i> Témoignages
        @elseif (Route::currentRouteName() == 'admin_witness_edit')
          <i class="fa fa-comment"></i> Editer le témoignage

        @elseif (Route::currentRouteName() == 'admin_contact')
          <i class="fa fa-envelope"></i> Messages
        @elseif (Route::currentRouteName() == 'admin_contact_show')
          <i class="fa fa-envelope"></i> Répondre au message
        @endif
      </h3>
    </div>
  </header>
</div>