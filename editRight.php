<?php
require_once "functions.php";

if (!$_SESSION['rights'] == 'admin') {
    goToPage('index.php');
}

$id = $_POST['id'];
$right = $_POST['right'];

$conn = connect();
updateUserInfo($conn, $id, 'rights', $right);
close($conn);
goToPage('rights.php');
?>