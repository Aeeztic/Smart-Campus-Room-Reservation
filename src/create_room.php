<?php
include 'db_connect.php';

$room_name = $_POST['room_name'];
$building = $_POST['building'];
$floor = $_POST['floor'];
$room_number = $_POST['room_number'];
$capacity = $_POST['capacity'];
$status = $_POST['status'];
$category_id = $_POST['category_id'];

$sql = "INSERT INTO room (room_name, building, floor, room_number, capacity, status, category_id)
        VALUES ('$room_name', '$building', '$floor', '$room_number', '$capacity', '$status', '$category_id')";

if ($conn->query($sql) === TRUE) {
    echo "Room added!";
} else {
    echo "Error: " . $conn->error;
}
?>