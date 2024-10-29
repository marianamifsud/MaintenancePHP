<?php
session_start();
require_once "functions.php";

$conn = connect();
$userId = $_SESSION['userId'];

if (isset($_POST['name'])) {
    $newName = ucwords(mysqli_real_escape_string($conn, trim($_POST['newName'])));
    updateUserInfo($conn, $userId, 'name', $newName);
    $_SESSION['name'] = $newName;
    goToPage('index.php');
}

if (isset($_POST['surname'])) {
    $newSurname = ucwords(mysqli_real_escape_string($conn, trim($_POST['newSurname'])));
    updateUserInfo($conn, $userId, 'surname', $newSurname);
    $_SESSION['surname'] = $newSurname;
    goToPage('index.php');
}

if (isset($_POST['password'])) {
    $newPassword = mysqli_real_escape_string($conn, trim($_POST['newPassword']));
    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    updateUserInfo($conn, $userId, 'password', $passwordHash);
    goToPage('index.php');
}

if (isset($_POST['image'])) {
    $newImage = $_FILES['newImage']['name'];
    $tmpPath = $_FILES['newImage']['tmp_name'];
    $userId = $_SESSION['userId'];
    $oldImage = $_SESSION['image'];
    $profilePic = saveNewUserImage($newImage, $tmpPath, $userId, $oldImage);
    $_SESSION['image'] = $profilePic;
    updateUserInfo($conn, $userId, 'profilePic', $profilePic);
    goToPage('index.php');
}
