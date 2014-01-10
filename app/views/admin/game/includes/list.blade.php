@if ($games->count())
  <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
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