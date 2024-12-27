<?php
session_start();

$_SESSION['assign'] = "nav-link active";

require_once '../db.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Determine the table based on the role
    $table = ($role === 'agent') ? 'agents' : 'users';

    // Prepare and execute the query
    $stmt = $db->prepare("INSERT INTO $table (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    $result = $stmt->execute();

    // Redirect with success or failure message
    if ($result) {
        header("Location: create-user.php?success=true");
    } else {
        header("Location: create-user.php?error=true");
    }
    exit();
}

// Get success or failure message from query string
$successMessage = $_GET['success'] ?? null;
$errorMessage = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Role</title>
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
                    <a class="<?php echo $_SESSION['assign'] ?? "nav-link" ?>" href="create-user.php">Assign Role</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../controller/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="register-container">
            <h2 class="mb-4 text-center">Assign Role</h2>
            <form action="create-user.php" method="post" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required />
                    <div class="invalid-feedback">Please provide your name.</div>
                </div>


                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option selected readonly>--Select a role--</option>
                        <option value="agent">Agent</option>
                        <option value="user">User</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a role.
                    </div>
                </div>
                <div class="mx-auto" style="width:120px;">
                    <button type="submit" class="btn btn-primary mt-3">Create User</button>
                </div>
            </form>
            <div class="mt-3">
                <?php
                if ($successMessage) {
                    echo '<div class="alert alert-success" role="alert">User created successfully!</div>';
                } elseif ($errorMessage) {
                    echo '<div class="alert alert-danger" role="alert">Failed to create user.</div>';
                }
                ?>
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
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>