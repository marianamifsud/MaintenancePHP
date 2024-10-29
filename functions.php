<?php

function connect()
{
    $conn = mysqli_connect("localhost", "root", "", "maintenancestores");
    return $conn;
}

function close($conn)
{
    mysqli_close($conn);
}

function goToPage($path)
{
    echo "<script>window.location.href = 'http://localhost/maintenance/$path'</script>";
}

function getTableInfo($conn, $table)
{
    $sql = "SELECT * FROM `$table`";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function getUserInfo($conn, $id)
{
    $sql = "SELECT * FROM `users` WHERE `userId` = $id";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function updateUserInfo($conn, $id, $column, $newData)
{
    $sql = "UPDATE `users` SET `$column` = '$newData' WHERE `userId` = $id";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function saveUserImage($link, $tmpPath)
{
    $profilePicFileType = pathinfo($link, PATHINFO_EXTENSION);

    $directory = getcwd() . "/assets/users/*";
    $filecount = 0;
    $files2 = glob($directory . "*");
    if ($files2) {
        $filecount = count($files2);
    }

    $destdir = "assets/users/user" . ($filecount) . '.' . $profilePicFileType;
    move_uploaded_file($tmpPath, $destdir);
    return $destdir;
}

function saveNewUserImage($link, $tmpPath, $userId, $oldpath)
{
    $profilePicFileType = pathinfo($link, PATHINFO_EXTENSION);
    unlink($oldpath);
    $destdir = "assets/updatedUsers/user" . ($userId) . '.' . $profilePicFileType;
    move_uploaded_file($tmpPath, $destdir);
    return $destdir;
}

function addItem($conn, $table, $quantity, $column, $id)
{
    $sql = "UPDATE `$table` SET `$column` = `$column` + '$quantity' WHERE `itemId` = '$id'";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function deductItem($conn, $table, $quantity, $column, $id)
{
    $sql = "UPDATE `$table` SET `$column`= `$column` - '$quantity' WHERE `itemId` = '$id'";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function deleteItem($conn, $table, $id)
{
    $sql = "DELETE FROM `$table` WHERE `itemId` = $id";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function insertItem($conn, $table, $name, $description, $quantity, $image, $price)
{
    $sql = "INSERT INTO `$table`(`itemName`, `description`, `itemQuantity`, `itemPic`, `price`) VALUES ('$name','$description','$quantity','$image','$price');";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function insertUser($conn, $table, $name, $surname, $email, $mobile, $password, $profilePic, $rights)
{
    $sql = "INSERT INTO `$table`(`name`, `surname`, `email`, `mobile`, `password`, `profilePic`, `rights`) VALUES ('$name','$surname','$email','$mobile','$password','$profilePic', '$rights');";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function checkEmail($conn, $userEmail)
{
    $users = getTableInfo($conn, "users");
    if ($users) {
        while ($item = mysqli_fetch_assoc($users)) {
            $email = $item['email'];

            if ($email == $userEmail) {
                return '<div class="mt-4 p-2 alert alert-danger">Email address already in use</div>';
            }
        }
    }
}

function checkMobile($conn, $userMobile)
{
    $users = getTableInfo($conn, "users");
    if ($users) {
        while ($item = mysqli_fetch_assoc($users)) {
            $mobile = $item['mobile'];

            if ($mobile == $userMobile) {
                return '<div class="mt-4 p-2 alert alert-danger">Mobile Number already in use</div>';
            }
        }
    }
}

function createTicket($conn, $table, $name, $description, $id)
{
    $sql = "INSERT INTO `$table`(`ticketName`, `ticketDescription`, `clientId`, `pending`, `price`, `paid`) VALUES ('$name','$description','$id',1,0,0);";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function createTransaction($conn, $table, $ticketId, $itemId, $quantity, $techId, $price)
{
    $sql = "INSERT INTO `$table` (`ticketId`, `itemId`, `quantity`, `technicianId`, `transactionPrice`) VALUES ('$ticketId', '$itemId', '$quantity', '$techId', '$price');";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function addPrice($conn, $table, $ticketId, $amount)
{
    $sql = "UPDATE `$table` SET `price` = `price` + '$amount' WHERE `ticketId` = '$ticketId'";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function getItemPrice($conn, $id)
{
    $sql = "SELECT * FROM `storeitems` WHERE `itemId` = $id";
    $res = mysqli_query($conn, $sql);
    $item = mysqli_fetch_assoc($res)['price'];
    return $item;
}

function getTicketInfo($conn, $id)
{
    $sql = "SELECT * FROM `tickets` WHERE `ticketId` = $id";
    $res = mysqli_query($conn, $sql);
    $info = mysqli_fetch_assoc($res);
    return $info;
}

function getTransactions($conn, $id)
{
    $sql = "SELECT t.quantity, t.transactionPrice, s.itemName, s.price FROM transactions t INNER JOIN storeitems s ON t.itemId = s.itemId WHERE t.ticketId = $id;";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function updateTicketPending($conn, $id)
{
    $sql = "UPDATE `tickets` SET `pending`= 0 WHERE ticketId = $id;";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function updateTicketPaid($conn, $id)
{
    $sql = "UPDATE `tickets` SET `paid`= 1 WHERE ticketId = $id;";
    $res = mysqli_query($conn, $sql);
    return $res;
}

function checkItem($conn, $id)
{
    $sql = "SELECT * FROM `transactions` WHERE `itemId` = $id";
    $res = mysqli_query($conn, $sql);
    $count = 0;
    while ($item = mysqli_fetch_assoc($res)) {
        $count += 1;
    }
    return $count;
}
