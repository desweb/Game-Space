<p>Bonjour {{ $user->username }},</p>

<p>Bienvenue sur la GameSpace!</p>

<p>Votre mot de passe : {{ $password }}</p>

{{ Config::get('email_signature') }}