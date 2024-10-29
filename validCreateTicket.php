<?php

require_once "functions.php";

session_start();

if (isset($_SESSION['userId'])) {
    $conn = connect();
    $id = $_SESSION['userId'];

    $name = ucwords(mysqli_real_escape_string($conn, trim($_POST['name'])));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $ticket = createTicket($conn, 'tickets', $name, $description, $id);
    close($conn);
    goToPage('index.php');
}
goToPage('index.php');
