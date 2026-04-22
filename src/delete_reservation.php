<?php
include 'db_connect.php';

$id = $_GET['id'];

$conn->query("DELETE FROM reservation WHERE reservation_id = $id");

header("Location: view_reservations.php");
exit();
?>