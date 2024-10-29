<?php
include "headerSection.php";
require_once "functions.php";

if (!isset($_POST['ticket'])) {
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
                <form id="create_ticket" action="validCreateTicket.php" method="POST">
                    <h1 class="mb-4">Create Ticket</h1>
                    <div class="row-auto">
                        <label for="ticket_name">Ticket Name</label>
                        <input type="text" class="form-control" name='name' id="ticket_name">
                    </div>
                    <div class="row-auto mt-2">
                        <label for="ticket_description">Ticket Description</label>
                        <textarea type="text" class="form-control" name="description" id="ticket_description"></textarea>
                    </div>
                    <div class="row-auto mt-4">
                        <button type="submit" class="btn btn-secondary" name="create" id="submit_ticket">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    <?php
    include "footer.php";
    ?>
    <script>
        const validator = new window.JustValidate("#create_ticket");
        validator
            .addField("#ticket_name", [{
                rule: "required",
            }, ])
            .addField("#ticket_description", [{
                rule: "required",
            }, ])
            .onSuccess((event) => {
                document.getElementById('create_ticket').submit();
            });
    </script>
</body>

</html>