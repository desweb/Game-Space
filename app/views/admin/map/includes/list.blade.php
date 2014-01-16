@if ($maps->count())
  <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
    <thead>
      <tr>
        <th>Cartes</th>
        <th>Dates de création</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($maps as $map)
        @include('admin.map.includes.row')
      @endforeach
    </tbody>
  </table>
@else
  <p>Aucune carte</p>
@endif