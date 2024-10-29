<?php
require_once "functions.php";
$conn = connect();
$name = mysqli_real_escape_string($conn, trim($_POST['name']));
$description = mysqli_real_escape_string($conn, trim($_POST['description']));
$quantity = mysqli_real_escape_string($conn, trim($_POST['quantity']));

$link = $_FILES['item_image']['name'];
$imageFileType = pathinfo($link, PATHINFO_EXTENSION);

$directory = getcwd() . "/assets/items/*";
$filecount = 0;
$files2 = glob($directory . "*");

if ($files2) {
    $filecount = count($files2);
}

$destdir = "assets/items/item" . ($filecount) . '.' . $imageFileType;
move_uploaded_file($_FILES['item_image']['tmp_name'], $destdir);
$image = $destdir;

$price = mysqli_real_escape_string($conn, trim($_POST['price']));
$res = insertItem($conn, "storeitems", $name, $description, $quantity, $image, $price);
close($conn);
goToPage('stores.php');
?>