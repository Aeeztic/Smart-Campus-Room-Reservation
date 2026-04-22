<?php
include 'db_connect.php';

$id = $_GET['id'];

$sql = "DELETE FROM room WHERE room_id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: view_rooms.php");
} else {
    echo "Error: " . $conn->error;
}
?>