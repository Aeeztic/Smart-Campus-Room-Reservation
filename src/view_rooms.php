<?php
include 'db_connect.php';

$result = $conn->query("SELECT * FROM room");

echo "<table border='1'>";
echo "<tr>
        <th> Room ID</th>
        <th>Room</th>
        <th>Building</th>
        <th>Action</th>
      </tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['room_id']."</td>";
    echo "<td>".$row['room_name']."</td>";
    echo "<td>".$row['building']."</td>";

    echo "<td>
            <a href='edit_room.php?id=".$row['room_id']."'>Edit</a> |
            <a href='delete_room.php?id=".$row['room_id']."'>Delete</a>
          </td>";

    echo "</tr>";
}

echo "</table>";
?>