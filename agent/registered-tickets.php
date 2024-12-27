<?php
session_start();

if(!isset($_SESSION['user_name'])){
   header("Location: ../amc-login.php");
   exit();
}

require_once '../db.php';
$agent_id = $_SESSION['user_id'];

$stmt = $db->prepare("SELECT * FROM tickets WHERE agent_id = ?");
$stmt->bind_param("i", $agent_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered User Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
        <a class="navbar-brand" href="agent_dashboard.php">Agent Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link"><strong>Welcome, <?php echo $_SESSION['user_name']??""; ?></strong></span>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="agent-dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../controller/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h2 class="mb-4">Guest User Tickets</h2>
        <form id="updateForm" method="POST" action="updateRegTickets.php">
            <table id="ticketsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Updated Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        ++$i;
                        echo "<tr>";
                        echo "<td>{$i}</td>";
                        echo "<td>{$row['subject']}</td>";
                        echo "<td>{$row['description']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td>";
                        echo "<select class='form-select status-select' name='updated-status[{$row['id']}]' data-ticket-id='{$row['id']}' data-table='tickets'>";
                        echo "<option value='open'>Open</option>";
                        echo "<option value='in-progress'>In Progress</option>";
                        echo "<option value='resolved'>Resolved</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "<td><input type='checkbox' class='update-checkbox' name='ticket_id[]' value='{$row['id']}'></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button type="submit" id="updateButton" class="btn btn-primary mt-3">Update</button>
            <div id="updateMessage" class="mt-3">
                <?php echo $_SESSION['update_message'] ?? "";
                unset($_SESSION['update_message'])
                ?>
            </div>
        </form>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#ticketsTable').DataTable();

            // Update button click event
            $('#updateForm').submit(function (event) {
                var selectedCheckboxes = $('.update-checkbox:checked');
                if (selectedCheckboxes.length === 0) {
                    event.preventDefault();
                    $('#updateMessage').text('Select a record to update').addClass('text-danger');
                } else if (selectedCheckboxes.length > 1) {
                    event.preventDefault();
                    $('#updateMessage').text('Select exactly one record to update').addClass(
                        'text-danger');
                } else {
                    // $('#updateMessage').text('');
                }
            });
        });
    </script>
</body>

</html>