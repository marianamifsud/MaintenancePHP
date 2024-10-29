<?php
include "headerSection.php";
require_once "functions.php";

if (isset($_SESSION['rights'])) {
    if ($_SESSION['rights'] === 'client') {
        goToPage('index.php');
    }
} else {
    goToPage('index.php');
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
        <?php
        if (isset($_SESSION['rights'])) {
            if ($_SESSION['rights'] == 'admin') {
        ?>
                <form action="insertItem.php" method="POST" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-primary mt-3" name="insert">Insert Item</button>
                </form>
                <?php

            }
        }
        $conn = connect();
        $stores = getTableInfo($conn, "storeitems");

        if ($stores) {
            while ($item = mysqli_fetch_assoc($stores)) {
                $id = $item['itemId'];
                $name = $item['itemName'];
                $description = $item['description'];
                $quantity = $item['itemQuantity'];
                $image = $item['itemPic'];
                $price = $item['price'];

                $transactionCount = checkItem($conn, $id);

                if ($name != 'TechHours') {
                ?>

                    <div class="card mt-3">
                        <div class=" row g-0">
                            <div class="col-xxl-4 d-flex align-items-center justify-content-center">
                                <img src=<?php echo $image; ?> alt="Store Item Image" style="width: 18rem;">
                            </div>
                            <div class="col-xxl-8 d-xxl-flex">
                                <div class="card-body col-xxl-8 d-flex flex-column justify-content-center">
                                    <h5 class="card-title"> <?php echo "$name"; ?> </h5>
                                    <p class="card-text"> <?php echo $description; ?></p>
                                    <p class="card-text"> Quantity: <?php echo $quantity; ?></p>
                                    <p class="card-text"> Price: €<?php echo $price; ?></p>
                                </div>
                                <div class="card-body col-xxl-2 d-flex flex-column justify-content-center me-2">
                                    <?php
                                    if (isset($_SESSION['rights'])) {
                                        if ($_SESSION['rights'] == 'admin') {
                                    ?>
                                            <form action="editItem.php" method="POST">
                                                <h5>Edit Item</h5>
                                                <div class="d-flex align-items-center mb-2">
                                                    <label for="amount" class="me-2 col-6">Amount: </label>
                                                    <div class="d-flex flex-column col-5">
                                                        <select name="amount">
                                                            <option value="0"></option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-secondary me-1 w-50" name="add">+</button>
                                                    <button class="btn btn-secondary w-50" name="deduct">-</button>
                                                </div>
                                            </form>
                                            <?php
                                            if ($transactionCount == 0) {
                                            ?>
                                                <div class="mt-2">
                                                    <a href="deleteItem.php?id='<?php echo $id; ?>'" class="btn btn-danger w-100">Delete</a>
                                                </div>
                                    <?php
                                            }
                                        }
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

        <?php
                }
            }
        }
        ?>
    </div>
    <?php
    close($conn);
    include "footer.php";
    ?>
</body>

</html>