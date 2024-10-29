<?php

require_once "functions.php";
if (isset($_SESSION['rights'])) {
    if ($_SESSION['rights'] === 'client' || $_SESSION['rights'] === 'user') {
        goToPage('index.php');
    }
}
else{
    goToPage('index.php');
}

$conn = connect();
$id = $_POST['id'];
$amount = mysqli_real_escape_string($conn, trim($_POST['amount']));

if (isset($_POST['add'])) {
    $res = addItem($conn, "storeitems", $amount, "itemQuantity", $id);
    goToPage('stores.php');
}

if (isset($_POST['deduct'])) {
    $res = deductItem($conn, "storeitems", $amount, "itemQuantity", $id);
    goToPage('stores.php');
}


close($conn);
