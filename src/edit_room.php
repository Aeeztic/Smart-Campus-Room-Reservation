<?php
include 'db_connect.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM room WHERE room_id = $id");
$room = $result->fetch_assoc();
?>

<form action="update_room.php" method="POST">
    <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">

    Room Name: <input type="text" name="room_name" value="<?php echo $room['room_name']; ?>"><br>
    Building: <input type="text" name="building" value="<?php echo $room['building']; ?>"><br>

    <button type="submit">Update</button>
</form>