<?php
session_start();
require_once 'db.php';

$message = '';
$ticketDetails = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ticket_number'])) {
    $ticketNumber = htmlspecialchars($_GET['ticket_number']);

    $selectQuery = "SELECT * FROM guest_tickets WHERE ticket_id = ?";

    $stmt = $db->prepare($selectQuery);
    $stmt->bind_param("s", $ticketNumber);
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $ticketDetails = $result->fetch_assoc();
        $message = '<strong style="color: green;">Ticket found!</strong>';
    } else {
        $message = '<strong style="color: red;">Ticket number not found.</strong>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Ticket Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include("includes/navbar.php") ?>


    <!-- Main Content -->
    <div class="container-fluid mb-5">
        <div class="raise-ticket-container">
            <h2 class="mb-4 text-center">View Ticket Status</h2>
            <form method="GET" action="view-status.php">
                <div class="form-group">
                    <label for="ticket_number">Enter Ticket Number:</label>
                    <input type="text" class="form-control" id="ticket_number" name="ticket_number" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Ticket Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalMessage">
                        <?php if (!empty($message)): ?>
                        <div class="text-center"><?php echo $message; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($ticketDetails)): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $ticketDetails['subject']; ?></td>
                                    <td><?php echo $ticketDetails['description']; ?></td>
                                    <td><?php echo $ticketDetails['status']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5 position-absolute start-0 end-0 bottom-0">
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
    <script>
        $(document).ready(function () {
            var message = '<?php echo isset($message) ? $message : '
            '; ?>';
            if (message) {
                $('#statusModal').modal('show');
            }
        });
    </script>
</body>

</html>