<table class="table table-striped responsive-table">
	<thead>
		<tr>
			<th>Jeux</th>
			<th>Niveaux</th>
			<th>Scores</th>
		</tr>
	</thead>
	<tbody>
		@foreach($user->games as $game)
			<tr>
				<td>{{ $game->game->title }}</td>
				<td>{{ $game->level }}</td>
				<td>{{ $game->score }} pt{{ $game->score > 0? 's': '' }}</td>
			</tr>
		@endforeach
	</tbody>
</table>