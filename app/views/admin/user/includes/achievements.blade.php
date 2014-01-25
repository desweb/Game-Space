<table class="table table-striped responsive-table">
	<thead>
		<tr>
			<th>Trophées</th>
			<th>Scores</th>
		</tr>
	</thead>
	<tbody>
		@foreach($user->achievements as $achievement)
			<tr>
				<td>{{ $achievement->displayUnlockLabel() }}{{ $achievement->achievement->title }}</td>
				<td>{{ $achievement->score }} / {{ $achievement->achievement->score }}</td>
			</tr>
		@endforeach
	</tbody>
</table>