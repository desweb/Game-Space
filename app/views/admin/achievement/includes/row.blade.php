<tr>
	<td>{{ HTML::image($achievement->image->url, $achievement->title, array('width' => '50px')) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $achievement->displayTitle() }}</td>
	<td>{{ $achievement->displayCreatedAt() }}</td>
	<td>{{ $achievement->displayActions() }}</td>
</tr>