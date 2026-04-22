<?php
include 'db_connect.php';

$result = $conn->query("SELECT * FROM users");

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['user_id']."</td>";
    echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
    echo "<td>".$row['email']."</td>";
    
    echo "<td>
            <a href='edit_user.php?id=".$row['user_id']."'>Edit</a> |
            <a href='delete_user.php?id=".$row['user_id']."'
               onclick=\"return confirm('Delete this user?')\">
               Delete
            </a>
          </td>";
    
    echo "</tr>";
}

echo "</table>";
?>