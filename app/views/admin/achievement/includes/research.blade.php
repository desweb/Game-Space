@if ($achievements->count())
  <table class="table responsive-table">
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