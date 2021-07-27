
<table>
  <tr>
    <th>ID</th>
    <th>TASK</th>
    <th>DESCR</th>
    <th>DATE</th>
    <th>Action</th>
  </tr>
@foreach($data as $r)
  <tr>
    <td>{{$r->id}}</td>
    <td>{{$r->task}}</td>
    <td>{{$r->descr}}</td>
    <td>{{$r->create_date}}</td>
    <td><a href="/edit/{{$r->id}}">Edit</a><a href="/del/{{$r->id}}">Delete</a></td>
  </tr>
@endforeach

</table>

