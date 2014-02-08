<table class="table responsive-table">
  <thead>
    <tr>
      <th>Administrateurs</th>
      <th>Emails</th>
      <th>Dates d'inscription</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($administrators as $administrator)
      @include('admin.administrator.includes.row')
    @endforeach
  </tbody>
</table>