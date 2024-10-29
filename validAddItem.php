<?php
session_start();
require_once "functions.php";

$conn = connect();

$item = $_POST['itemSelect'];
$quantity = mysqli_real_escape_string($conn, trim($_POST['quantity']));

$techId = $_SESSION['userId'];
$ticketId = $_SESSION['ticketID'];
$itemPrice = getItemPrice($conn, $item);
$res = createTransaction($conn, 'transactions', $ticketId, $item, $quantity, $techId, $itemPrice * $quantity);
$price = addPrice($conn, 'tickets', $ticketId, $itemPrice * $quantity);

$res = deductItem($conn, "storeitems", $quantity, "itemQuantity", $item);

close($conn);

goToPage('index.php');
?>