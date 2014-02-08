@if ($games->count())
  <table class="table responsive-table">
    <thead>
      <tr>
        <th>Jeux</th>
        <th>Dates de création</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($games as $game)
        @include('admin.game.includes.row')
      @endforeach
    </tbody>
  </table>
@else
  <p>Aucun jeu</p>
@endif