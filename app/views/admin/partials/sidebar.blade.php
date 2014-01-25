<div id="left">
  <div class="media user-media">
    <a class="user-link" href="{{ route('admin_profile') }}">
      {{ HTML::image(Auth::user()->photo->url, Auth::user()->username, array('class' => 'media-object img-thumbnail user-img')) }}
    </a>
    <div class="media-body">
      <h5 class="media-heading">{{ HTML::link(route('admin_profile'), Auth::user()->username) }}</h5>
      <ul class="list-unstyled user-info">
        <li>Administrateur</li>
      </ul>
    </div>
  </div>

  @include('admin.partials.menu')
</div>