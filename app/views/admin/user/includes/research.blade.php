@if ($users->count())
  <table class="table responsive-table">
    <thead>
      <tr>
        <th>Utilisateurs</th>
        <th>Emails</th>
        <th>Dates d'inscription</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
        @include('admin.user.includes.row')
      @endforeach
    </tbody>
  </table>
@else
  <p>Aucun utilisateur</p>
@endif