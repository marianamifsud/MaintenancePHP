<?php
include "headerSection.php";
require_once "functions.php";

if ($_SESSION['rights']) {
    if ($_SESSION['rights'] == 'client' || $_SESSION['rights'] == 'user') {
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
</head>

<body class="flex-column d-flex h-100">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center mt-4">
            <form method="POST" action="validInsertItem.php" enctype="multipart/form-data" id="item_form" autocomplete="off" novalidate="novalidate">
                <h2 class="mb-2">Insert Item</h2>
                <div class="row-auto">
                    <label for="name">Item Name</label>
                    <input type="text" class="form-control" name='name' id='name'>
                </div>
                <div class="row-auto mt-1">
                    <label for="description">Description</label>
                    <textarea type="text" class="form-control" name="description" id="description"></textarea>
                </div>
                <div class="row-auto mt-1">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" name="quantity" id="quantity">
                </div>
                <div class="row-auto mt-1">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" name="item_image" id="image">
                </div>
                <div class="row-auto mt-1">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" name="price" id="price">
                </div>
                <div class="row-auto mt-2">
                    <button type="submit" class="btn btn-secondary" name="newItem">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <?php
    include "footer.php";
    ?>
    <script>
        const validator = new window.JustValidate("#item_form");
        validator
            .addField("#name", [{
                rule: "required",
                errorMessage: 'Item name is required',
            }, {
                rule: 'minLength',
                value: 3,
            }, ])
            .addField("#description", [{
                rule: "required",
                errorMessage: 'Description is required',
            }, {
                rule: 'minLength',
                value: 3,
            }, ])
            .addField("#quantity", [{
                rule: "required",
                errorMessage: 'Quantity must be a number',
            }, {
                rule: 'integer',
            }, ])
            .addField("#image", [{
                    rule: 'minFilesCount',
                    value: 1,
                    errorMessage: 'Image is required',
                }, {
                    rule: 'maxFilesCount',
                    value: 2,
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
            .addField("#price", [{
                rule: "required",
                errorMessage: 'Price is required',
            }, {
                rule: 'number',
                errorMessage: 'Price must be a number',
            }, ])
            .onSuccess((event) => {
                document.getElementById('item_form').submit();
            });
    </script>
</body>

</html>