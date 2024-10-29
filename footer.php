<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Maintenance</title>
</head>

<body>
  <footer class="footer mt-auto py-3">
    <div class="container">
      <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li><a href="index.php" class="nav-link px-2">All Tickets</a></li>
        <?php
        if (isset($_SESSION['rights'])) {

          if ($_SESSION['rights'] == 'admin') {
        ?>
            <form action="stores.php" method="POST" enctype="multipart/form-data">
              <button type="submit" class="nav-link px-2" name="stores">
                Stores
              </button>
            </form>
            <form action="rights.php" method="POST" enctype="multipart/form-data">
              <li>
                <button type="submit" class="nav-link px-2" name="rights">
                  Rights
                </button>
              </li>
            </form>
          <?php
          }

          if ($_SESSION['rights'] == 'user') {
          ?>
            <form action="stores.php" method="POST" enctype="multipart/form-data">
              <button type="submit" class="nav-link px-2" name="stores">
                Stores
              </button>
            </form>
        <?php
          }
        } ?>
      </ul>
      <p class="text-center text-body-secondary">Created By Mariana Mifsud</p>
    </div>
  </footer>
</body>

</html>