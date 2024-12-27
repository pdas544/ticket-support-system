<?php
session_start();

if(!isset($_SESSION['user_name'])){
   header("Location: ../amc-login.php");
   exit();
}

require_once '../db.php';
$agent_id = $_SESSION['user_id'];

// Get total number of registered user tickets
$regTicketsStmt = $db->prepare("SELECT COUNT(*) AS total FROM tickets WHERE agent_id = ?");
$regTicketsStmt->bind_param("i", $agent_id);
$regTicketsStmt->execute();
$regTicketsResult = $regTicketsStmt->get_result();
$regTicketsRow = $regTicketsResult->fetch_assoc();
$regTicketsTotal = $regTicketsRow['total'];

// Get total number of guest tickets
$guestTicketsStmt = $db->prepare("SELECT COUNT(*) AS total FROM guest_tickets WHERE agent_id = ?");
$guestTicketsStmt->bind_param("i", $agent_id);
$guestTicketsStmt->execute();
$guestTicketsResult = $guestTicketsStmt->get_result();
$guestTicketsRow = $guestTicketsResult->fetch_assoc();
$guestTicketsTotal = $guestTicketsRow['total'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="agent_dashboard.php">Agent Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link"><strong>Welcome, <?php echo $_SESSION['user_name']??""; ?></strong></span>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="agent_dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../controller/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-auto">
                <div class="card">
                    <h5 class="card-header">
                        Registered User Tickets
                    </h5>
                    <div class="card-body">
                        <h5 class="card-title">Total Tickets: <?php echo $regTicketsTotal; ?></h5>
                    </div>

                    <a href="registered-tickets.php" class="btn btn-primary">View Tickets</a>

                </div>
            </div>
            <div class="col-auto">
                <div class="card">
                    <h5 class="card-header">
                        Guest User Tickets
                    </h5>
                    <div class="card-body">
                        <h5 class="card-title">Total Tickets: <?php echo $guestTicketsTotal; ?></h5>
                    </div>

                    <a href="guest-tickets.php" class="btn btn-primary">View Tickets</a>

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <p>&copy; 2023 Ticketing Support. All rights reserved.</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>