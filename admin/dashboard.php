<?php 

session_start();

if(!(isset($_SESSION['user_name']) && $_SESSION['user_name']=="admin")){
   header("Location: ../login-user.php");
   exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
        <a class="navbar-brand" href="dashboard.php">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link">Welcome, Admin</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create-agent.php">Create Agent</a>
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
                <div class="card" style="width:18rem;height:15rem">
                    <h5 class="card-header">
                        Registered User Tickets
                    </h5>
                    <div class="card-body">
                        <p class="card-title">View and Manage Registered User Tickets</p>
                    </div>
                    <a href="view-reg-tickets.php" class="btn btn-primary">View Tickets</a>

                </div>
            </div>
            <div class="col-auto">
                <div class="card" style="width:18rem;height:15rem;">
                    <h5 class="card-header">
                        Guest User Tickets
                    </h5>
                    <div class="card-body">
                        <p class="card-title">View and Manage Guest User Tickets</p>
                    </div>
                    <a href="view-guest-tickets.php" class="btn btn-primary">View Tickets</a>

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5 position-absolute start-0 end-0">
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>