@if ($user->witnesses->count())
	<table class="table table-striped responsive-table">
		<thead>
			<tr>
				<th>Jeux</th>
				<th>Notes</th>
				<th>Témoignages</th>
			</tr>
		</thead>
		<tbody>
			@foreach($user->witnesses as $witness)
				<tr>
					<td>{{ $witness->game->title }}</td>
					<td>{{ $witness->displayStar() }}</td>
					<td>{{ $witness->message }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	<p>Aucun témoignage</p>
@endif