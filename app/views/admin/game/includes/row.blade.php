<tr>
	<td>{{ HTML::image($game->image->url, $game->title, array('width' => '50px')) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $game->displayTitle() }}</td>
	<td>{{ $game->displayCreatedAt() }}</td>
	<td>{{ $game->displayActions() }}</td>
</tr>