<p>Bonjour {{ $user_token->user->username }},</p>

<p>Une demande de réinitialisation de votre mot de passe a été demandée.</p>

<p>Pour réinitialiser votre mot de passe, vous pouvez suivre le lien suivant : {{ HTML::link(route('token', array('token' => $user_token->token)), 'Réinitialiser mon mot de passe') }}.</p>

<p>Si vous n'êtes pas à l'origine de cet email, vous pouvez l'ignorer.</p>

{{ Config::get('email_signature') }}