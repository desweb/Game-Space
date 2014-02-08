@if ($contacts->count())
  <table class="table responsive-table">
    <thead>
      <tr>
        <th>Messages</th>
        <th>Emails</th>
        <th>Objets</th>
        <th>Dates de réception</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($contacts as $contact)
        @include('admin.contact.includes.row')
      @endforeach
    </tbody>
  </table>
@else
  <p>Aucun message</p>
@endif