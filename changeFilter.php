<?php
session_start();
require_once "functions.php";
$status = $_POST['ticketFilter'];
$_SESSION['ticketFilter'] = $status;
goToPage('index.php');
?>