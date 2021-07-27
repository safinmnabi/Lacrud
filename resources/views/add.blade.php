<form method="POST">
  @csrf

  <input type="text" name="task" value="{{$single->task ?? null}}">
  <br>
  <input type="text" name="description" value="{{$single->descr ?? null}}">
  <br>
  <button type="submit">Submit</button>
</form>