<?php
require_once "functions.php";
$id = $_GET['id'];
$conn = connect();
$res = updateTicketPending($conn, $id);
goToPage('index.php');
?>