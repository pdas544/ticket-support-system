<?php
session_start();

if(!(isset($_SESSION['user_name']) && $_SESSION['user_name']=="admin")){
   header("Location: ../login-user.php");
   exit();
}

require_once '../db.php';
require_once '../vendor/autoload.php'; // Include PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Handle date filter
$fromDate = isset($_POST['from_date']) ? $_POST['from_date'] : null;
$toDate = isset($_POST['to_date']) ? $_POST['to_date'] : null;

$query = "SELECT t.*, u.name AS user_name, a.name AS agent_name FROM tickets t LEFT JOIN users u ON t.user_id = u.id LEFT JOIN agents a ON t.agent_id = a.id";
if ($fromDate && $toDate) {
    $query .= " WHERE t.created_at BETWEEN ? AND ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ss", $fromDate, $toDate);
} else {
    $stmt = $db->prepare($query);
}
$stmt->execute();
$result = $stmt->get_result();

// Handle export request
if (isset($_GET['export']) && $_GET['export'] == 'true') {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Tickets');

    // Set headers
    
    $sheet->setCellValue('A1', 'Sl. No');
    $sheet->setCellValue('B1', 'Subject');
    $sheet->setCellValue('C1', 'Description');
    $sheet->setCellValue('D1', 'Assigned To');
    $sheet->setCellValue('E1', 'Created At');
    $sheet->setCellValue('F1', 'Updated At');
    $sheet->setCellValue('G1', 'Status');

    $sheet->getStyle('A1:G1')->getFont()->setBold(true);

    $row = 2;
    $serial = 1;
    while ($ticket = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $serial);
        $sheet->setCellValue('B' . $row, $ticket['subject']);
        $sheet->setCellValue('C' . $row, $ticket['description']);
        $sheet->setCellValue('D' . $row, $ticket['agent_name']);
        $sheet->setCellValue('E' . $row, $ticket['created_at']);
        $sheet->setCellValue('F' . $row, $ticket['updated_at']);
        $sheet->setCellValue('G' . $row, $ticket['status']);
        $row++;
        $serial++;
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'tickets_' . date('Ymd_His') . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registered Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
        <a class="navbar-brand" href="dashboard.php">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link">Welcome, Admin</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
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
        <h2 class="mb-4">View Registered Tickets</h2>
        <form id="dateFilterForm" method="POST" action="view-reg-tickets.php">
            <div class="container d-flex flex-column">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <label for="from_date">From</label>
                        <input type="date" class="form-control" id="from_date" name="from_date" required>
                    </div>
                    <div class="col-md-4">
                        <label for="to_date">To</label>
                        <input type="date" class="form-control" id="to_date" name="to_date"
                            value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mt-4">Get Records</button>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <button type="button" id="viewAllRecords" class="btn btn-secondary mt-4">View All
                            Records</button>
                    </div>
                </div>
            </div>
            <div id="message" class="mt-3">

            </div>
        </form>

        <!-- Export Button -->
        <div class="mt-3 d-flex justify-content-between align-items-center">
            <button id="exportButton" class="btn btn-success">Export</button>
        </div>

        <div class="mt-3">

            <table id="regTicketsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Subject</th>
                        <th>Description</th>

                        <th>Assigned To</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $serial = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$serial}</td>";
                        echo "<td>{$row['subject']}</td>";
                        echo "<td>{$row['description']}</td>";
                        
                        echo "<td>{$row['agent_name']}</td>";
                        echo "<td>{$row['created_at']}</td>";
                        echo "<td>{$row['updated_at']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td><a href='update-reg-record.php?id={$row['id']}' class='btn btn-sm btn-primary update-icon' style='display:none;'><i class='fas fa-edit'></i></a></td>";
                        echo "<td><input type='checkbox' class='update-checkbox' name='ticket_id[]' value='{$row['id']}'></td>";
                        echo "</tr>";
                        $serial++;
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <!-- Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p id="messageText"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
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
            $('#regTicketsTable').DataTable();

            // Date validation
            $('#dateFilterForm').submit(function (event) {
                var fromDate = new Date($('#from_date').val());
                var toDate = new Date($('#to_date').val());
                if (fromDate > toDate) {
                    event.preventDefault();
                    $('#message').html(
                        '<div class="alert alert-danger">From date cannot be greater than To date.</div>'
                    );

                }
            });
            // View all records button
            $('#viewAllRecords').click(function () {
                window.location.href = 'view-reg-tickets.php';
            });

            // Enable update icon only when checkbox is selected
            $('.update-checkbox').change(function () {
                var updateIcon = $(this).closest('tr').find('.update-icon');
                if ($(this).is(':checked')) {
                    updateIcon.show();
                } else {
                    updateIcon.hide();
                }
            });

            // Export button click event
            $('#exportButton').click(function () {
                window.location.href = 'view-reg-tickets.php?export=true';
            });

            var urlParams = new URLSearchParams(window.location.search);

            var updateMessage = urlParams.get("update");
            if (updateMessage === "false") {
                $("#messageText").text("Record was not updated");
                $("#messageModal").modal("show");
            } else if (updateMessage === "true") {
                $("#messageText").text("Record updated successfully.");
                $("#messageModal").modal("show");
            }
        });
    </script>
</body>

</html>