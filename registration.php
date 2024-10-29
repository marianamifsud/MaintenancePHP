<?php
include "headerSection.php";
require_once "functions.php";

if (isset($_SESSION['rights'])) {
    if ($_SESSION['rights'] == 'admin' || $_SESSION['rights'] == 'user' || $_SESSION['rights'] == 'client') {
        goToPage('index.php');
    }
}

$name = $surname = $userEmail = $userMobile = $password = $profilePic = '';

if (isset($_POST['submit'])) {
    $allFilled = false;
    $detailsCorrect = false;

    $conn = connect();
    $name = ucwords(mysqli_real_escape_string($conn, trim($_POST['name'])));
    $surname = ucwords(mysqli_real_escape_string($conn, trim($_POST['surname'])));
    $userEmail = mysqli_real_escape_string($conn, trim($_POST['email']));
    $userMobile = mysqli_real_escape_string($conn, trim($_POST['mobile']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $profilePic = $_FILES['profilePic']['name'];
}
?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body class="flex-column d-flex h-100">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <form method="POST" enctype="multipart/form-data">
                <h2 class="my-3">Create Account</h2>
                <div class="row mt-2">
                    <label for="name">First Name</label>
                    <div>
                        <input type="text" class="form-control" name='name' value="<?php echo $name; ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="surname">Last Name</label>
                    <div>
                        <input type="text" class="form-control" name='surname' value="<?php echo $surname; ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="email">Email</label>
                    <div>
                        <input type="text" class="form-control" name="email" value="<?php echo $userEmail; ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="mobile">Mobile</label>
                    <div>
                        <input type="text" class="form-control" name="mobile" value="<?php echo $userMobile; ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="password">Password</label>
                    <div>
                        <input type="password" class="form-control" name="password" value="<?php echo $password; ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="profilePic">Profile Picture</label>
                    <div>
                        <input type="file" class="form-control" name="profilePic">
                    </div>
                </div>
                <div class="row-auto mt-2">
                    <button type="submit" class="btn btn-secondary" name="submit">Submit</button>
                </div>

                <?php
                if (isset($_POST['submit'])) {
                    if (empty($name) || empty($surname) || empty($userEmail) || empty($userMobile) || empty($password) || empty($profilePic)) {
                        $allFilled = false;
                ?>
                        <div class="mt-4 p-2 alert alert-danger">All Fields are required</div>
                        <?php
                    } else {
                        $allFilled = true;
                        $detailsCorrect = true;

                        $emailAlert = checkEmail($conn, $userEmail);
                        if ($emailAlert) {
                            $detailsCorrect = false;
                            echo $emailAlert;
                        }

                        $mobileAlert = checkMobile($conn, $userMobile);
                        if ($mobileAlert) {
                            $detailsCorrect = false;
                            echo $mobileAlert;
                        }

                        if (strlen($password) < 3) {
                            $detailsCorrect = false;
                        ?>
                            <div class="mt-4 p-2 alert alert-danger">Password must be at least 3 characters long</div>
                        <?php
                        }

                        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                            $detailsCorrect = false;
                        ?>
                            <div class="mt-4 p-2 alert alert-danger">Email is not valid</div>
                        <?php
                        }

                        if (!preg_match("/^[a-zA-Z]*$/", $name)) {
                            $detailsCorrect = false;
                        ?>
                            <div class="mt-4 p-2 alert alert-danger">First Name must be only characters</div>
                        <?php
                        }

                        if (!preg_match("/^[a-zA-Z]*$/", $surname)) {
                            $detailsCorrect = false;
                        ?>
                            <div class="mt-4 p-2 alert alert-danger">Last Name must be only characters</div>
                        <?php
                        }

                        if (strlen($name) > 15) {
                            $detailsCorrect = false;
                        ?>
                            <div class="mt-4 p-2 alert alert-danger">First Name can't be longer than 15 characters</div>
                        <?php
                        }

                        if (strlen($surname) > 15) {
                            $detailsCorrect = false;
                        ?>
                            <div class="mt-4 p-2 alert alert-danger">Last Name can't be longer than 15 characters</div>
                        <?php
                        }

                        if (!is_numeric($userMobile)) {
                            $detailsCorrect = false;
                        ?>
                            <div class="mt-4 p-2 alert alert-danger">Mobile Number can only contain digits</div>
                        <?php
                        }

                        if (strlen($userMobile) != 8) {
                            $detailsCorrect = false;
                        ?>
                            <div class="mt-4 p-2 alert alert-danger">Mobile Number has to contain 8 digits</div>
                        <?php
                        }

                        $imageFileType = pathinfo($profilePic, PATHINFO_EXTENSION);
                        $valid_extensions = array("jpg", "jpeg", "png");
                        if (!in_array($imageFileType, $valid_extensions)) {
                            $detailsCorrect = false;
                        ?>
                            <div class="mt-4 p-2 alert alert-danger">Image type is invalid</div>
                <?php
                        }
                        if ($allFilled && $detailsCorrect) {
                            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                            $link = $_FILES['profilePic']['name'];
                            $tmpPath = $_FILES['profilePic']['tmp_name'];

                            $profilePic = saveUserImage($link, $tmpPath);
                            $rights = 'client';

                            $res = insertUser($conn, "users", $name, $surname, $userEmail, $userMobile, $passwordHash, $profilePic, $rights);
                            close($conn);
                            goToPage('index.php');
                        }
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