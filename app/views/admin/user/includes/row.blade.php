<tr>
	<td>{{ HTML::image($user->photo->url, $user->username, array('width' => '50px')) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->displayStateLabel() }}{{ $user->displayUsername() }}</td>
	<td>{{ $user->email }}</td>
	<td>{{ $user->displayCreatedAt() }}</td>
	<td>{{ $user->displayActions() }}</td>
</tr>