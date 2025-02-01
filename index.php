<?php

// include("includes/initialize.php");
require_once 'db.php';

function getTotalTickets() {
    global $db;
    $stmt = $db->prepare("SELECT COUNT(*) AS total FROM tickets UNION ALL SELECT COUNT(*) AS total FROM guest_tickets");
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $total += $row['total'];
    }
    return $total;
}

function getTicketsRaisedToday() {
    global $db;
    $stmt = $db->prepare("SELECT COUNT(*) AS total FROM tickets WHERE DATE(created_at) = CURDATE() UNION ALL SELECT COUNT(*) AS total FROM guest_tickets WHERE DATE(created_at) = CURDATE()");
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $total += $row['total'];
    }
    return $total;
}

function getPendingTickets() {
    global $db;
    $stmt = $db->prepare("SELECT COUNT(*) AS total FROM tickets WHERE status = 'open' OR status = 'in-progress' UNION ALL SELECT COUNT(*) AS total FROM guest_tickets WHERE status = 'open' OR status = 'in-progress'");
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $total += $row['total'];
    }
    return $total;
}

function getResolvedTickets() {
    global $db;
    $stmt = $db->prepare("SELECT COUNT(*) AS total FROM tickets WHERE status = 'resolved' UNION ALL SELECT COUNT(*) AS total FROM guest_tickets WHERE status = 'resolved'");
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $total += $row['total'];
    }
    return $total;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketing Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
</head>

<body class="">
    <?php include("includes/navbar.php") ?>

    <!-- Main Content -->
    <div class="container mt-5">
        <h2 class="mb-5 text-center">Ticket Statistics</h2>
        <div class="row justify-content-center">
            <!-- Total Tickets -->
            <div class="col-md-3 total-tickets">
                <div class="card">
                    <div class="card-header">Total Tickets</div>
                    <div class="card-body"><?php echo getTotalTickets(); ?></div>
                </div>
            </div>
            <!-- Total Tickets Raised Today -->
            <div class="col-md-3 today-tickets">
                <div class="card">
                    <div class="card-header">Tickets Raised Today</div>
                    <div class="card-body"><?php echo getTicketsRaisedToday(); ?></div>
                </div>
            </div>
            <!-- Total Pending Tickets -->
            <div class="col-md-3 pending-tickets">
                <div class="card">
                    <div class="card-header">Pending Tickets</div>
                    <div class="card-body"><?php echo getPendingTickets(); ?></div>
                </div>
            </div>
            <!-- Total Resolved Tickets -->
            <div class="col-md-3 resolved-tickets">
                <div class="card">
                    <div class="card-header">Resolved Tickets</div>
                    <div class="card-body"><?php echo getResolvedTickets(); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5 float-sm-start float-md-none position-sm-sticky position-md-none">
        <div class="container">
            <p>&copy; 2023 Ticketing Support. All rights reserved.</p>

        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>