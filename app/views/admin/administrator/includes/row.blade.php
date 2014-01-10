<tr>
	<td>{{ HTML::image($administrator->photo->url, $administrator->username, array('width' => '50px')) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $administrator->displayAdminUsername() }}</td>
	<td>{{ $administrator->email }}</td>
	<td>{{ $administrator->displayCreatedAt() }}</td>
	<td>{{ $administrator->displayAdminActions() }}</td>
</tr>