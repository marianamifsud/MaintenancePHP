<?php
if (!isset($_POST['edit'])) {
    goToPage('index.php');;
}
require_once "functions.php";
$conn = connect();
$items = getTableInfo($conn, "storeitems");

include "headerSection.php";
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
        <div class="d-flex flex-column align-items-center justify-content-center mt-4">
            <h1 class="mb-5">Insert Transaction</h1>
            <div class="row">
                <div class="col-lg-6 d-flex flex-column">
                    <form method="POST" action="validAddHours.php" id="hours_form">
                        <div class="col-12">
                            <h6>Enter Technician Hours</h6>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-4">
                                    <input type="number" class="form-control border border-warning w-75" name="hours" id="hours">
                                </div>
                                <div class="col-8">
                                    <button class="btn btn-warning" name="hoursSubmit">Submit Hours</button>
                                </div>
                            </div>
                            <div class="col-12" id="errordiv"></div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 d-flex flex-column">
                    <form method="POST" action="validAddItem.php" id="item_form">
                        <div class="col-12">
                            <h6>Choose Item Used</h6>
                        </div>

                        <div class="col-12">
                            <select class="form-control border border-info w-100" id="itemSelect" name="itemSelect">
                                <option selected></option>
                                <?php
                                if ($items) {
                                    while ($item = mysqli_fetch_assoc($items)) {
                                        $itemId = $item['itemId'];
                                        $name = $item['itemName'];
                                        $quantity = $item['itemQuantity'];
                                        if ($quantity > 0) {
                                ?>
                                            <option value="<?php echo $itemId; ?>"><?php echo $name; ?></option>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-12 mt-4">
                            <h6>Enter Item Quantity</h6>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-4">
                                    <input type="number" class="form-control border border-info w-75" name="quantity" id="quantity">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-info" name="quantity">Submit Quantity</button>
                                </div>
                            </div>
                            <div class="col-12" id="quantityError"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    include "footer.php";
    ?>
    <script>
        const validatorHours = new window.JustValidate("#hours_form");
        validatorHours
            .addField("#hours", [{
                rule: "required",
                errorMessage: 'The hours amount is required',
            }, {
                rule: 'number',
                errorMessage: 'The hours amount must be a number',
            }, ], {
                errorsContainer: '#errordiv',
            })
            .onSuccess((event) => {
                document.getElementById('hours_form').submit();
            });

        const validatorItem = new window.JustValidate("#item_form");
        validatorItem
            .addField("#itemSelect", [{
                rule: "required",
                errorMessage: 'The item must be chosen',
            }, ])
            .addField("#quantity", [{
                rule: "required",
                errorMessage: 'The item quantity is required',
            }, {
                rule: 'number',
                errorMessage: 'The item quantity must be a number',
            }, ], {
                errorsContainer: '#quantityError',
            })
            .onSuccess((event) => {
                document.getElementById('item_form').submit();
            });
    </script>
</body>

</html>