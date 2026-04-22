<?php
include 'db_connect.php';

$id = $_POST['user_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role_id = $_POST['role_id'];

$sql = "UPDATE users 
        SET first_name='$first_name',
            last_name='$last_name',
            email='$email',
            password='$password',
            role_id='$role_id'
        WHERE user_id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: view_users.php");
} else {
    echo "Error: " . $conn->error;
}
?>