<?php
require_once "functions.php";
$id = $_GET['id'];
$conn = connect();
$res = deleteItem($conn, "storeitems", $id);
goToPage('stores.php');
