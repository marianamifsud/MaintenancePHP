<?php
include "headerSection.php";
require_once "functions.php";

if (!isset($_POST['view'])) {
    goToPage('index.php');
}

$conn = connect();
$ticketId = $_POST['ticketId'];
$clientFullName = $_POST['clientFullName'];

$_SESSION['ticketID'] = $ticketId;

$ticket = getTicketInfo($conn, $ticketId);
$ticketName = $ticket['ticketName'];
$ticketDescription = $ticket['ticketDescription'];
$pending = $ticket['pending'];
$price = $ticket['price'];
$paid = $ticket['paid'];

$transactions = getTransactions($conn, $ticketId);
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
        <div class="card mt-4">
            <div class=" card-header">
                <div class="row">
                    <div class="col d-flex align-items-center">
                        <h5 class="card-title">Ticket Number: <?php echo $ticketId; ?></h5>
                    </div>
                    <?php
                    if ($pending == 1) {
                    ?>
                        <div class="col-auto d-flex justify-content-end">
                            <button class="btn btn-danger">Pending</button>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-auto d-flex justify-content-end">
                            <button class="btn btn-success">Finished</button>
                        </div>
                    <?php
                    }
                    ?>
                </div>

            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo $ticketName; ?></h5>
                <p class="card-text"><?php echo $ticketDescription; ?></p>
                <div class="d-md-flex">
                    <div class="col-md-10 col-sm-12">

                        <ul class="list-group list-group-flush">
                            <?php
                            if ($transactions) {
                                while ($details = mysqli_fetch_assoc($transactions)) {
                                    $quantity = $details['quantity'];
                                    $t_price = $details['transactionPrice'];
                                    $name = $details['itemName'];
                            ?>
                                    <li class="list-group-item"><?php echo $name . ' - Quantity: ' . $quantity . ' - €' . $t_price; ?></li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                    if ($pending == 1 && $_SESSION['rights'] != 'client') {
                    ?>
                        <div class="col-sm-12 col-md-2 d-md-flex justify-content-end align-items-end">
                            <form action="editTicket.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="ticketId" value="<?php echo $ticketId; ?>">
                                <button type="submit" class="btn btn-info text-white" name="edit">Add Transaction</button>
                            </form>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="card-footer text-body-secondary">
                <div class="row">
                    <div class="col-xxl-8 d-md-flex align-items-center">Created By: <?php echo $clientFullName; ?></div>
                    <?php
                    if ($pending == 0) {
                    ?>
                        <div class="col-xxl-4 col-sm-12 d-flex">
                            <div class="col-xxl-8 col-sm-2 d-flex align-items-center justify-content-end">
                                <div class="card-text">Price: &euro;<?php echo $price; ?></div>
                            </div>
                        <?php
                    } else {
                        ?>
                            <div class="col-xxl-8 col-sm-2"></div>
                        <?php
                    }
                        ?>
                        <?php
                        if ($paid == 1) {
                        ?>
                            <div class="col-xxl-4 d-flex align-items-center justify-content-end">
                                <button class="btn btn-primary">Paid</button>
                            </div>
                        <?php
                        }
                        if ($pending == 1 && $_SESSION['rights'] != 'client') {
                        ?>
                            <div class="col-xxl-4 d-flex align-items-center justify-content-end">
                                <a href="ticketPending.php?id=<?php echo $ticketId; ?>" class="btn btn-warning">Job Finished</a>
                            </div>
                        <?php
                        }
                        if ($paid == 0 && $pending == 0 && $_SESSION['rights'] == 'client') {
                        ?>
                            <div class="col-xxl-4 d-flex align-items-center justify-content-end">
                                <a href="ticketPayment.php?id=<?php echo $ticketId; ?>" class="btn btn-warning">Pay Ticket</a>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    include "footer.php";
    ?>
</body>

</html>