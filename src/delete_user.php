<?php
include 'db_connect.php';

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE user_id = $id";

if ($conn->query($sql) === TRUE) {
    echo "User deleted!";
} else {
    echo "Error: " . $conn->error;
}

// Redirect back to table
header("Location: view_users.php");
exit();
?>