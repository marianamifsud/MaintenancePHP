<?php
session_start();
require_once "functions.php";
if (isset($_SESSION['rights'])) {
  $rights = $_SESSION['rights'];
} else {
  $rights = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Maintenance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
</head>

<body>
  <div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 border-bottom">
      <nav class="navbar navbar-expand-lg">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index.php" class="nav-link px-2">All Tickets</a>
          </li>
          <?php
          if (isset($_SESSION['rights'])) {

            if ($_SESSION['rights'] == 'admin') {
          ?>
              <li class="nav-item">
                <form action="stores.php" method="POST" enctype="multipart/form-data">
                  <button type="submit" class="nav-link px-2" name="stores">Stores</button>
                </form>
              </li>
              <li class="nav-item">
                <form action="rights.php" method="POST" enctype="multipart/form-data">
                  <button type="submit" class="nav-link px-2" name="rights">Rights</button>
                </form>
              </li>
            <?php
            }

            if ($_SESSION['rights'] == 'user') {
            ?>
              <form action="stores.php" method="POST" enctype="multipart/form-data">
                <button type="submit" class="nav-link px-2" name="stores">Stores</button>
              </form>
          <?php
            }
          } ?>
        </ul>
      </nav>
      <nav class="navbar navbar-expand-lg">
        <div class="navbar-nav">

          <?php
          if ($rights) {
            $image = $_SESSION['image'];
            $name = $_SESSION['name'];
            $surname = $_SESSION['surname'];
          ?>
            <div class="d-flex align-items-center me-3">Hello <?php echo $name . ' ' . $surname; ?></div>
            <form action="editUser.php" method="POST" enctype="multipart/form-data">
              <button type="submit" class="d-block me-3 mt-1 border-0 bg-white" name="img">
                <img src="<?php echo $image; ?>" width="32" height="32">
              </button>
            </form>
            <form action="logout.php" method="POST" enctype="multipart/form-data">
              <button type="submit" class="btn btn-outline-primary me-2" name="logout">Log Out</button>
            </form>
          <?php
          } else {
          ?>
            <form action="login.php" method="POST" enctype="multipart/form-data">
              <button type="submit" class="btn btn-outline-primary me-2" name="log">Login</button>
            </form>

            <form action="registration.php" method="POST" enctype="multipart/form-data">
              <button type="submit" class="btn btn-primary" name="register">Register</button>
            </form>
          <?php
          }
          ?>
        </div>
      </nav>
    </header>
  </div>
</body>

</html>