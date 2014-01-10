<div id="lost" class="tab-pane{{ isset($is_active)? ' active': '' }}">

  <form method="post" action="{{ route('admin_lost_password_validation') }}" class="form-signin">
    {{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Email', 'required' => true)) }}
    <br>
    {{ Form::button('Réinitialiser mon mot de passe', array('type' => 'submit', 'class' => 'btn btn-lg btn-primary btn-block')) }}
    <br>
    <div class="text-center">
      <ul class="list-inline">
        <li>{{ HTML::link('#login', 'Se connecter', array('class' => 'text-muted', 'data-toggle' => 'tab')) }}</li>
      </ul>
    </div>
  {{ Form::close() }}

</div>