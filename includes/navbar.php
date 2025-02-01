<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light px-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Ticketing Support</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Guest
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="raise-ticket.php?guest=true">Raise Ticket</a></li>
                        <li><a class="dropdown-item" href="view-status.php">View Ticket Status</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login-user.php">Sign In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register-user.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="amc-login.php">AMC Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>