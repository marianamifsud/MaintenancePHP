<?php
session_start();
require_once "functions.php";

$conn = connect();

$hours = mysqli_real_escape_string($conn, trim($_POST['hours']));
$techId = $_SESSION['userId'];
$ticketId = $_SESSION['ticketID'];
$itemPrice = getItemPrice($conn, 54);
$res = createTransaction($conn, 'transactions', $ticketId, 54, $hours, $techId, $hours * $itemPrice);
$price = addPrice($conn, 'tickets', $ticketId, $hours * $itemPrice);

close($conn);

goToPage('index.php');
?>