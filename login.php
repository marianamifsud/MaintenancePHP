<?php
include "headerSection.php";
require_once "functions.php";

if (isset($_SESSION['rights'])) {
    if ($_SESSION['rights'] == 'admin' || $_SESSION['rights'] == 'user' || $_SESSION['rights'] == 'client') {
        goToPage('index.php');
    }
}

$userDetails = $userPassword = '';

if (isset($_POST['login'])) {
    $conn = connect();
    $users = getTableInfo($conn, "users");


    $userDetails = mysqli_real_escape_string($conn, trim($_POST['details']));
    $userPassword = mysqli_real_escape_string($conn, trim($_POST['password']));

    $allFilled = true;
    $detailsCorrect = true;
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
</head>

<body class="flex-column d-flex h-100">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center mt-4">
            <form method="POST" enctype="multipart/form-data">
                <h1 class="mb-4">Login</h1>
                <div class="row mt-2">
                    <label for="details">Email / Mobile Number:</label>
                    <div>
                        <input type="text" name="details" class="form-control" value="<?php echo $userDetails; ?>">
                    </div>
                </div>
                <div class="row-auto mt-2">
                    <label for="password">Password:</label>
                    <div>
                        <input type="password" name="password" class="form-control" value="<?php echo $userPassword; ?>">
                    </div>
                </div>
                <div class="row-auto mt-4">
                    <button class="btn btn-secondary" name="login">Login</button>
                </div>


                <?php
                if (isset($_POST['login'])) {
                    if (empty($userDetails) || empty($userPassword)) {
                        $allFilled = false;
                ?>
                        <div class="mt-4 p-2 alert alert-danger">All Fields are required</div>
                        <?php
                    } else {
                        if (strlen($userPassword) < 3) {
                            $detailsCorrect = false;
                        ?>
                            <div class="mt-4 p-2 alert alert-danger">Password must be at least 3 characters long</div>
                        <?php
                        }

                        if (!is_numeric($userDetails) && !filter_var($userDetails, FILTER_VALIDATE_EMAIL)) {
                            $detailsCorrect = false;
                        ?>
                            <div class="mt-4 p-2 alert alert-danger">Email is not valid</div>
                        <?php
                        }
                    }
                    if ($allFilled && $detailsCorrect) {
                        $userPasswordHash = password_hash($userPassword, PASSWORD_DEFAULT);

                        if ($users) {
                            while ($item = mysqli_fetch_assoc($users)) {
                                $userId = $item['userId'];
                                $name = $item['name'];
                                $surname = $item['surname'];
                                $email = $item['email'];
                                $mobile = $item['mobile'];
                                $password = $item['password'];
                                $rights = $item['rights'];
                                $image = $item['profilePic'];

                                if (($email == $userDetails || $mobile == $userDetails) && (password_verify($userPassword, $userPasswordHash))) {
                                    if ($rights == 'admin') {
                                        $_SESSION['rights'] = 'admin';
                                    } else if ($rights == 'user') {
                                        $_SESSION['rights'] = 'user';
                                    } else {
                                        $_SESSION['rights'] = 'client';
                                    }
                                    $_SESSION['image'] = $image;
                                    $_SESSION['name'] = $name;
                                    $_SESSION['surname'] = $surname;
                                    $_SESSION['userId'] = $userId;
                                    goToPage('index.php');
                                }
                            }
                        }
                        ?>
                        <div class="mt-4 p-2 alert alert-danger">Email / Mobile Number or Password entered does not exist</div>
                <?php
                        close($conn);
                    }
                }

                ?>
            </form>

        </div>
    </div>
    <?php
    include "footer.php";
    ?>
</body>

</html>