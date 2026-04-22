<?php
include 'db_connect.php';

$id = $_POST['room_id'];
$room_name = $_POST['room_name'];
$building = $_POST['building'];

$sql = "UPDATE room 
        SET room_name='$room_name',
            building='$building'
        WHERE room_id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: view_rooms.php");
} else {
    echo "Error: " . $conn->error;
}
?>