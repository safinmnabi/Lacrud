<form method="POST">
  @csrf

  <input type="text" name="fullname">
  <br>
  <input type="email" name="email">
  <br>
  <input type="password" name="password">
  <br>
  <input type="number" name="role">
  <br>
  <button type="submit">Submit</button>
</form>