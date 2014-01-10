<tr>
	<td>{{ $contact->displayReadLabel() }}Message de {{ $contact->username }}</td>
	<td>{{ $contact->email }}</td>
	<td>{{ $contact->getObject() }}</td>
	<td>{{ $contact->displayCreatedAt() }}</td>
	<td>{{ $contact->displayActions() }}</td>
</tr>