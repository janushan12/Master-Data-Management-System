<?php
include '../includes/auth.php';
include '../includes/db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM master_items WHERE id = $id");
header("Location:list.php");
?>