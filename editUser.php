<?php
include "headerSection.php";
require_once "functions.php";

if (!isset($_POST['img'])) {
    goToPage('index.php');
}

$conn = connect();
$userId = $_SESSION['userId'];
$user = getUserInfo($conn, $userId);
if ($user) {
    $userInfo = mysqli_fetch_assoc($user);
    $name = $userInfo['name'];
    $surname = $userInfo['surname'];
    $email = $userInfo['email'];
    $mobile = $userInfo['mobile'];
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
    <div class="d-flex align-items-center justify-content-center mt-4">
        <div>
            <h1 class="mb-4">Edit Account</h1>
            <div class="row mt-2">
                <form method="POST" action="validEditUser.php" id="name_form" autocomplete="off" novalidate="novalidate">
                    <label for="name">Name</label>
                    <div class="d-flex">
                        <div class="w-100">
                            <input type="text" class="form-control" name='newName' id='newName' value="<?php echo $name; ?>">
                        </div>
                        <input type="hidden" name="name">
                        <button type="submit" class="btn btn-secondary ms-4" name="changeName">Change</button>
                    </div>
                </form>
            </div>
            <div class="row mt-2">
                <form method="POST" action="validEditUser.php" id="surname_form" autocomplete="off" novalidate="novalidate">
                    <label for="surname">Surname</label>
                    <div class="d-flex">
                        <div class="w-100">
                            <input type="text" class="form-control" name='newSurname' id='newSurname' value="<?php echo $surname; ?>">
                        </div>
                        <input type="hidden" name="surname">
                        <button type="submit" class="btn btn-secondary ms-4" name="changeSurname">Change</button>
                    </div>
                </form>
            </div>
            <div class="row mt-2">
                <form method="POST" action="validEditUser.php" id="password_form" autocomplete="off" novalidate="novalidate">
                    <label for="password">Password</label>
                    <div class="d-flex">
                        <div class="w-100">
                            <input type="password" class="form-control" name="newPassword" id="newPassword">
                        </div>
                        <input type="hidden" name="password">
                        <button type="submit" class="btn btn-secondary ms-4" name="changePassword">Change</button>
                    </div>
                </form>
            </div>
            <div class="row mt-2">
                <form method="POST" enctype="multipart/form-data" action="validEditUser.php" id="image_form" autocomplete="off" novalidate="novalidate">
                    <label for="profilePic">Profile Picture</label>
                    <div class="d-flex">
                        <div class="w-100">
                            <input type="file" class="form-control" name="newImage" id="newImage">
                        </div>
                        <input type="hidden" name="image">
                        <button type="submit" class="btn btn-secondary ms-4" name="changeImage">Change</button>
                    </div>
                </form>
            </div>
            <?php
            ?>
        </div>
    </div>
    <?php
    include "footer.php";
    ?>
    <script>
        const validatorName = new window.JustValidate("#name_form");
        validatorName
            .addField("#newName", [{
                rule: "required",
                errorMessage: 'Name is required',
            }, {
                rule: 'minLength',
                value: 3,
            }, {
                rule: 'maxLength',
                value: 15,
            }, {
                rule: 'customRegexp',
                value: /^[a-zA-Z]+$/,
                errorMessage: 'Name must be only characters',
            }])
            .onSuccess((event) => {
                document.getElementById('name_form').submit();
            });
        const validatorSurname = new window.JustValidate("#surname_form");
        validatorSurname
            .addField("#newSurname", [{
                rule: "required",
                errorMessage: 'Surname is required',
            }, {
                rule: 'minLength',
                value: 3,
            }, {
                rule: 'maxLength',
                value: 15,
            }, {
                rule: 'customRegexp',
                value: /^[a-zA-Z]+$/,
                errorMessage: 'Surname must be only characters',
            }])
            .onSuccess((event) => {
                document.getElementById('surname_form').submit();
            });
        const validatorPassword = new window.JustValidate("#password_form");
        validatorPassword
            .addField("#newPassword", [{
                rule: "required",
                errorMessage: 'Password is required',
            }, {
                rule: 'minLength',
                value: 3,
            }, ])
            .onSuccess((event) => {
                document.getElementById('password_form').submit();
            });
        const validatorImage = new window.JustValidate("#image_form");
        validatorImage
            .addField("#newImage", [{
                    rule: 'minFilesCount',
                    value: 1,
                    errorMessage: 'Image is required',
                },
                {
                    rule: 'maxFilesCount',
                    value: 1,
                },
                {
                    rule: 'files',
                    value: {
                        files: {
                            extensions: ['jpeg', 'jpg', 'png'],
                            types: ['image/jpeg', 'image/jpg', 'image/png'],
                        },
                    },
                    errorMessage: 'File type is invalid',
                },
            ])
            .onSuccess((event) => {
                document.getElementById('image_form').submit();
            });
    </script>
</body>

</html>