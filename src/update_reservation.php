<?php
include 'db_connect.php';

$id = $_POST['reservation_id'];
$user_id = $_POST['user_id'];
$room_id = $_POST['room_id'];
$date = $_POST['reservation_date'];
$start = $_POST['start_time'];
$end = $_POST['end_time'];
$purpose = $_POST['purpose'];
$status = $_POST['status'];

// 🔴 CHECK CONFLICT (exclude current reservation)
$check = "SELECT * FROM reservation 
          WHERE room_id = '$room_id'
          AND reservation_date = '$date'
          AND reservation_id != '$id'
          AND (
              start_time < '$end' AND end_time > '$start'
          )";

$result = $conn->query($check);

if ($result->num_rows > 0) {
    echo "❌ Time conflict! Cannot update.";
} else {
    $sql = "UPDATE reservation 
            SET user_id='$user_id',
                room_id='$room_id',
                reservation_date='$date',
                start_time='$start',
                end_time='$end',
                purpose='$purpose',
                status='$status'
            WHERE reservation_id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_reservations.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>