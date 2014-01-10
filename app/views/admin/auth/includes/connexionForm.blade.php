<div id="login" class="tab-pane{{ isset($is_active)? ' active': '' }}">

  <form method="post" action="{{ route('admin_login_validation') }}" class="form-signin">
    {{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Email', 'required' => true)) }}
    <input type="password" name="password" placeholder="Mot de passe" class="form-control" required>
    {{ Form::button('Me connecter', array('type' => 'submit', 'class' => 'btn btn-lg btn-primary btn-block')) }}
    <br>
    <div class="text-center">
      <ul class="list-inline">
        <li>{{ HTML::link('#lost', 'Mot de passe oublié ?', array('class' => 'text-muted', 'data-toggle' => 'tab')) }}</li>
      </ul>
    </div>
  {{ Form::close() }}

</div> 