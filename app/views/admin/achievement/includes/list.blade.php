@if ($achievements->count())
  <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
    <thead>
      <tr>
        <th>Trophées</th>
        <th>Dates de création</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($achievements as $achievement)
        @include('admin.achievement.includes.row')
      @endforeach
    </tbody>
  </table>
@else
  <p>Aucun trophée</p>
@endif