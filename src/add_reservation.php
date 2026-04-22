<form action="create_reservation.php" method="POST">
    <select name="user_id">
<?php
include 'db_connect.php';
$result = $conn->query("SELECT * FROM users");

while($row = $result->fetch_assoc()) {
    echo "<option value='{$row['user_id']}'>
            {$row['first_name']} {$row['last_name']}
          </option>";
}
?>
</select>
   <select name="room_id">
<?php
$result = $conn->query("SELECT * FROM room");

while($row = $result->fetch_assoc()) {
    echo "<option value='{$row['room_id']}'>
            {$row['room_name']}
          </option>";
}
?>
</select>
    Date: <input type="date" name="reservation_date"><br>
    Start Time: <input type="time" name="start_time"><br>
    End Time: <input type="time" name="end_time"><br>
    Purpose: <input type="text" name="purpose"><br>
    Status: <input type="text" name="status"><br>

    <button type="submit">Reserve</button>
</form>