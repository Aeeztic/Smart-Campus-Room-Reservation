<?php
include 'db_connect.php';

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM reservation WHERE reservation_id = $id");
$res = $result->fetch_assoc();
?>

<form action="update_reservation.php" method="POST">
    <input type="hidden" name="reservation_id" value="<?php echo $res['reservation_id']; ?>">

    User ID: <input type="number" name="user_id" value="<?php echo $res['user_id']; ?>"><br>
    Room ID: <input type="number" name="room_id" value="<?php echo $res['room_id']; ?>"><br>
    Date: <input type="date" name="reservation_date" value="<?php echo $res['reservation_date']; ?>"><br>
    Start Time: <input type="time" name="start_time" value="<?php echo $res['start_time']; ?>"><br>
    End Time: <input type="time" name="end_time" value="<?php echo $res['end_time']; ?>"><br>
    Purpose: <input type="text" name="purpose" value="<?php echo $res['purpose']; ?>"><br>
    Status: <input type="text" name="status" value="<?php echo $res['status']; ?>"><br>

    <button type="submit">Update Reservation</button>
</form>