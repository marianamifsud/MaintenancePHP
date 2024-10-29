<?php
include "headerSection.php";
require_once "functions.php";

if (!$_SESSION['rights'] == 'admin') {
    goToPage('index.php');
}

$conn = connect();
$users = getTableInfo($conn, "users");
close($conn);
?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
</head>

<body class="flex-column d-flex h-100">
    <div class="container mt-3 d-flex flex-row justify-content-around flex-wrap">
        <?php
        if ($users) {
            while ($item = mysqli_fetch_assoc($users)) {
                $name = $item['name'];
                $surname = $item['surname'];
                $rights = $item['rights'];
                $image = $item['profilePic'];
                $id = $item['userId'];
        ?>
                <div class="d-flex col-xs-12 col-sm-5 col-xl-3 m-md-2">
                    <div class="card mb-3 d-flex align-items-center w-100">
                        <div class="mt-2">
                            <img src=<?php echo $image; ?> class="img-fluid rounded-start" style="max-height: 50px;" alt="User Profile Image">
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <label for="fullName">Full Name:</label>
                                <h5 class="card-title ms-2"> <?php echo $name . ' ' . $surname; ?> </h5>
                            </div>
                            <div class="d-flex align-items-center justify-content-around">
                                <form action="editRight.php" method="POST" enctype="multipart/form-data">
                                    <label for="rights">Rights:</label>
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <select type="submit" name="right" onchange="this.form.submit()">
                                        <option value="admin" <?php if ($rights == 'admin') {
                                                                    echo 'selected';
                                                                } ?>>admin</option>
                                        <option value="user" <?php if ($rights == 'user') {
                                                                    echo 'selected';
                                                                } ?>>user</option>
                                        <option value="client" <?php if ($rights == 'client') {
                                                                    echo 'selected';
                                                                } ?>>client</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

        <?php
            }
        }
        ?>
    </div>
    <?php
    include "footer.php";
    ?>
</body>

</html>