<div id="recover" class="tab-pane{{ isset($is_active)? ' active': '' }}">

  <form method="post" action="{{ route('admin_recover_password_validation', array('token' => $user_token->token)) }}" class="form-signin">
    <input type="password" name="password" placeholder="Nouveau mot de passe" class="form-control">
    <input type="password" name="password_confirm" placeholder="Confirmation du nouveau mot de passe" class="form-control">
    <br>
    {{ Form::button('Réinitialiser mon mot de passe', array('type' => 'submit', 'class' => 'btn btn-lg btn-primary btn-block')) }}
  {{ Form::close() }}

</div>