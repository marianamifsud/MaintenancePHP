<?php
include "headerSection.php";
require_once "functions.php";

$filterTicket = '';

if (isset($_SESSION['ticketFilter'])) {
    $filterTicket = $_SESSION['ticketFilter'];
} else {
    $_SESSION['ticketFilter'] = 'pending';
    $filterTicket = $_SESSION['ticketFilter'];
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
    <div class="container mb-4">
        <div class="d-flex align-items-center mt-3">
            <?php
            if (isset($_SESSION['rights'])) {
                if ($_SESSION['rights'] == 'admin' || $_SESSION['rights'] == 'user' || $_SESSION['rights'] == 'client') {
            ?>
                    <form action="createTicket.php" method="POST" enctype="multipart/form-data">
                        <button type="submit" class="btn btn-primary me-4" name="ticket">Create Ticket</button>
                    </form>
            <?php
                }
            }
            ?>
            <form action="changeFilter.php" method="POST">
                <select name="ticketFilter" id="ticketFilter" class="form-control border border-info" onchange="this.form.submit()">
                    <option value="pending" <?php if ($filterTicket == 'pending') {
                                                echo 'selected';
                                            }; ?>>Pending</option>
                    <option value="unpaid" <?php if ($filterTicket == 'unpaid') {
                                                echo 'selected';
                                            }; ?>>Unpaid</option>
                    <option value="paid" <?php if ($filterTicket == 'paid') {
                                                echo 'selected';
                                            }; ?>>Paid</option>
                    <option value="all" <?php if ($filterTicket == 'all') {
                                            echo 'selected';
                                        }; ?>>All</option>
                </select>
            </form>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4 mt-2">
            <?php
            $conn = connect();
            $tickets = getTableInfo($conn, "tickets");

            if ($tickets) {
                while ($item = mysqli_fetch_assoc($tickets)) {
                    $ticketId = $item['ticketId'];
                    $name = $item['ticketName'];
                    $description = $item['ticketDescription'];
                    $pending = $item['pending'];
                    $paid = $item['paid'];

                    $clientId = $item['clientId'];
                    $clientInfo = getUserInfo($conn, $clientId);
                    $client = mysqli_fetch_assoc($clientInfo);
                    $clientName = $client['name'];
                    $clientSurname = $client['surname'];
                    if (($filterTicket == 'pending' && $pending == 1) || ($filterTicket == 'unpaid' && $pending == 0 && $paid == 0) || ($filterTicket == 'paid' && $pending == 0 && $paid == 1) || ($filterTicket == 'all')) {
            ?>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header">
                                    Ticket Number: <?php echo $ticketId; ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $name; ?></h5>
                                    <p class="card-text"><?php echo $description; ?></p>
                                </div>
                                <?php
                                if (isset($_SESSION['rights'])) {
                                    if ($_SESSION['rights'] == 'admin' || $_SESSION['rights'] == 'user' || $_SESSION['rights'] == 'client') {
                                ?>
                                        <form action="ticket.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="ticketId" value="<?php echo $ticketId; ?>">
                                            <input type="hidden" name="clientFullName" value="<?php echo $clientName . ' ' . $clientSurname; ?>">
                                            <?php
                                            if (($clientId == $_SESSION['userId'] && $_SESSION['rights'] == 'client') || $_SESSION['rights'] == 'user' || $_SESSION['rights'] == 'admin') {
                                            ?>
                                                <button type="submit" class="btn btn-secondary ms-3 mb-2" name="view">View</button>
                                            <?php
                                            }
                                            ?>
                                        </form>
                                <?php
                                    }
                                }
                                ?>

                                <div class="card-footer text-body-secondary">
                                    Created By: <?php echo $clientName . ' ' . $clientSurname; ?>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                }
            }
            close($conn);
            ?>
        </div>
    </div>
    <?php
    include "footer.php";
    ?>
</body>

</html>