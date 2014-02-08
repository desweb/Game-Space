@if ($witnesses->count())
  <table class="table responsive-table">
    <thead>
      <tr>
        <th>Témoignages</th>
        <th>Jeux</th>
        <th>Dates de création</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($witnesses as $witness)
        @include('admin.witness.includes.row')
      @endforeach
    </tbody>
  </table>
@else
  <p>Aucun témoignage</p>
@endif