<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Admin User</title>
</head>
<body>
  <h2>Create Admin User</h2>

  <form action="../auth/create_admin.php" method="POST">
    <label for="username">Username:</label><br>
    <input type="text" name="username" id="username" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" id="email" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password" required><br><br>

    <label for="first_name">First Name:</label><br>
    <input type="text" name="first_name" id="first_name" required><br><br>

    <label for="last_name">Last Name:</label><br>
    <input type="text" name="last_name" id="last_name" required><br><br>

    <label for="role">Role:</label><br>
    <select name="role" id="role" required>
      <option value="admin">Admin</option>
      <option value="manager">Manager</option>
      <option value="staff">Staff</option>
    </select><br><br>

    <label for="is_active">Active:</label><br>
    <select name="is_active" id="is_active">
      <option value="1">Yes</option>
      <option value="0">No</option>
    </select><br><br>

    <button type="submit">Submit</button>
  </form>

</body>
</html>
