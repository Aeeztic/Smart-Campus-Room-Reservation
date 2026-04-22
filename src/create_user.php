<?php
include 'db_connect.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role_id = $_POST['role_id'];

$sql = "INSERT INTO users (first_name, last_name, email, password, role_id)
        VALUES ('$first_name', '$last_name', '$email', '$password', '$role_id')";

if ($conn->query($sql) === TRUE) {
    echo "User added!";
} else {
    echo "Error: " . $conn->error;
}
?>