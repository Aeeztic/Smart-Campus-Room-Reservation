<?php
include 'db_connect.php';

$sql = "
SELECT 
    r.reservation_id,
    u.first_name,
    u.last_name,
    rm.room_name,
    r.reservation_date,
    r.start_time,
    r.end_time,
    r.status
FROM reservation r
JOIN users u ON r.user_id = u.user_id
JOIN room rm ON r.room_id = rm.room_id
";

$result = $conn->query($sql);

echo "<table border='1'>";
echo "<tr>
        <th>ID</th>
        <th>User</th>
        <th>Room</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Action</th>
      </tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['reservation_id']."</td>";
    echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
    echo "<td>".$row['room_name']."</td>";
    echo "<td>".$row['reservation_date']."</td>";
    echo "<td>".$row['start_time']." - ".$row['end_time']."</td>";
    echo "<td>".$row['status']."</td>";

    echo "<td>
            <a href='edit_reservation.php?id=".$row['reservation_id']."'>Edit</a> |
            <a href='delete_reservation.php?id=".$row['reservation_id']."'>Delete</a>
          </td>";

    echo "</tr>";
}

echo "</table>";
?>