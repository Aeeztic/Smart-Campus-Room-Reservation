<?php
include 'db_connect.php';

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM users WHERE user_id = $id");
$user = $result->fetch_assoc();
?>

<form action="update_user.php" method="POST">
    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

    First Name: <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>"><br>
    Last Name: <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>"><br>
    Email: <input type="text" name="email" value="<?php echo $user['email']; ?>"><br>
    Password: <input type="text" name="password" value="<?php echo $user['password']; ?>"><br>
    Role ID: <input type="number" name="role_id" value="<?php echo $user['role_id']; ?>"><br>

    <button type="submit">Update User</button>
</form>