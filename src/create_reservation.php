<?php
include 'db_connect.php';

$user_id = $_POST['user_id'];
$room_id = $_POST['room_id'];
$date = $_POST['reservation_date'];
$start = $_POST['start_time'];
$end = $_POST['end_time'];
$purpose = $_POST['purpose'];
$status = $_POST['status'];

// 🔴 CHECK FOR CONFLICT
$check = "SELECT * FROM reservation 
          WHERE room_id = '$room_id'
          AND reservation_date = '$date'
          AND (
              start_time < '$end' AND end_time > '$start'
          )";

$result = $conn->query($check);

if ($result->num_rows > 0) {
    echo "❌ Room already booked for this time!";
} else {
    // ✅ INSERT if no conflict
    $sql = "INSERT INTO reservation 
            (user_id, room_id, reservation_date, start_time, end_time, purpose, status)
            VALUES ('$user_id', '$room_id', '$date', '$start', '$end', '$purpose', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Reservation successful!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>