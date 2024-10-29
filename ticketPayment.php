<?php
require_once "functions.php";
$id = $_GET['id'];
$conn = connect();
$res = updateTicketPaid($conn, $id);
goToPage('index.php');
?>