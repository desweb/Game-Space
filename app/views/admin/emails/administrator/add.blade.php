<p>Bonjour {{ $administrator->username }},</p>

<p>Votre compte administrateur de la GameSpace vient d'être créé.</p>

<p>Vous pouvez des à présent vous connecter à l'administration de la GameSpace : {{ HTML::link('admin_home', 'Accéder à l\'administration') }}.</p>

<p>
	Vos identifiants :<br/>
	Pseudo : <b>{{ $administrator->username }}</b><br/>
	Mot de passe : <b>{{ $password }}</b>
</p>

<p>L'équipe GameSpace</p>