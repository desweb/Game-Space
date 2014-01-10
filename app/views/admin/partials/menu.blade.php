<ul id="menu" class="collapse">
  <li class="nav-divider"></li>
  <li{{ Route::currentRouteName() == 'admin_home'? ' class="active"': ''}}>
    <a href="{{ route('admin_home') }}">
      <i class="fa fa-dashboard"></i>
      <span class="link-title">&nbsp;&nbsp;Dashboard</span>
    </a>
  </li>
  <li>
    <a href="{{ Config::get('url_analytics') }}" target="_blank">
      <i class="fa fa-dashboard"></i>
      <span class="link-title">&nbsp;&nbsp;Universal Analytics</span>
    </a>
  </li>
  <li{{ Route::currentRouteName() == 'admin_administrator' || Route::currentRouteName() == 'admin_administrator_add' || Route::currentRouteName() == 'admin_administrator_edit'? ' class="active"': ''}}>
    <a href="javascript:;">
      <i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;Administrateurs
      <span class="fa arrow"></span>
    </a>
    <ul>
      <li>
        <a href="{{ route('admin_administrator') }}">
          <i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Tous les administrateurs
        </a>
      </li>
      <li>
        <a href="{{ route('admin_administrator_add') }}">
          <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Ajouter un administrateur
        </a>
      </li>
    </ul>
  </li>
  <li{{ Route::currentRouteName() == 'admin_user' || Route::currentRouteName() == 'admin_user_edit'? ' class="active"': ''}}>
    <a href="{{ route('admin_user') }}">
      <i class="fa fa-user"></i>
      <span class="link-title">&nbsp;&nbsp;Utilisateurs</span>
    </a>
  </li>
  <li>
    <a href="javascript:;">
      <i class="fa fa-globe"></i>&nbsp;&nbsp;&nbsp;Cartes
      <span class="fa arrow"></span>
    </a>
    <ul>
      <li>
        <a href="icon.html">
          <i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Gestion de la carte principale
        </a>
      </li>
      <li>
        <a href="button.html">
          <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;G&eacute;n&eacute;rateur de carte
        </a>
      </li>
    </ul>
  </li>
  <li{{ Route::currentRouteName() == 'admin_game' || Route::currentRouteName() == 'admin_game_add' || Route::currentRouteName() == 'admin_game_edit'? ' class="active"': ''}}>
    <a href="javascript:;">
      <i class="fa fa-bookmark"></i>&nbsp;&nbsp;&nbsp;Jeux
      <span class="fa arrow"></span>
    </a>
    <ul>
      <li>
        <a href="{{ route('admin_game') }}">
          <i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Tous les jeux
        </a>
      </li>
      <li>
        <a href="{{ route('admin_game_add') }}">
          <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Ajouter un jeu
        </a>
      </li>
    </ul>
  </li>
  <li{{ Route::currentRouteName() == 'admin_witness' || Route::currentRouteName() == 'admin_witness_edit'? ' class="active"': ''}}>
    <a href="{{ route('admin_witness') }}">
      <i class="fa fa-comment"></i>
      <span class="link-title">&nbsp;&nbsp;T&eacute;moignages</span>

      @if ($total_witnesses_waiting)
        <span class="label label-danger">{{ $total_witnesses_waiting }}</span>
      @endif
    </a>
  </li>
  <li>
    <a href="{{ route('admin_contact') }}">
      <i class="fa fa-envelope"></i>
      <span class="link-title">&nbsp;&nbsp;Messages</span>

      @if ($total_contact_waiting)
        <span class="label label-danger">{{ $total_contact_waiting }}</span>
      @endif
    </a>
  </li>
</ul>