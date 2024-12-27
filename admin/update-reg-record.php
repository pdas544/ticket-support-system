<?php
session_start();
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    date_default_timezone_set('Asia/Kolkata');
    $updatedAt = date("Y-m-d H:i:s");

    $ticketId = $_POST['ticket_id'];
    $assignedTo = $_POST['assigned_to'];
    $updatedStatus = $_POST['updated_status'];

    $stmt = $db->prepare("UPDATE tickets SET agent_id = ?, status = ?, updated_at=? WHERE id = ?");
    $stmt->bind_param("issi", $assignedTo, $updatedStatus, $updatedAt,$ticketId);
    $result = $stmt->execute();

    if ($result) {
        header("Location: view-reg-tickets.php?update=true");
        exit();
    } else {
        header("Location: view-reg-tickets.php?update=false");
        exit();
    }
}

if (isset($_GET['id'])) {
    $ticketId = $_GET['id'];
    $stmt = $db->prepare("SELECT t.*, u.name AS user_name, a.name AS agent_name FROM tickets t LEFT JOIN users u ON t.user_id = u.id LEFT JOIN agents a ON t.agent_id = a.id WHERE t.id = ?");
    $stmt->bind_param("i", $ticketId);
    $stmt->execute();
    $result = $stmt->get_result();
    $ticket = $result->fetch_assoc();

    // Fetch all agents
    $agentsStmt = $db->prepare("SELECT id, name FROM agents");
    $agentsStmt->execute();
    $agentsResult = $agentsStmt->get_result();
    $agents = $agentsResult->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
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
                    <a class="nav-link" href="view-reg-tickets.php">View Tickets</a>
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
    <div class="container w-25">
        <h2 class="mb-4">Update Record</h2>
        <form id="updateRecordForm" method="POST" action="update-reg-record.php">
            <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
            <div class="col-auto">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject"
                    value="<?php echo $ticket['subject']; ?>" readonly>
            </div>
            <div class="col-auto">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description"
                    readonly><?php echo $ticket['description']; ?></textarea>
            </div>
            <div class="col-auto">
                <label for="assigned_to">Assigned To</label>
                <select class="form-select" id="assigned_to" name="assigned_to">
                    <?php foreach ($agents as $agent): ?>
                    <option value="<?php echo $agent['id']; ?>"
                        <?php echo $agent['id'] == $ticket['agent_id'] ? 'selected' : ''; ?>>
                        <?php echo $agent['name']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <label for="updated_status">Updated Status</label>
                <select class="form-select" id="updated_status" name="updated_status">
                    <option value="open" <?php echo $ticket['status'] == 'open' ? 'selected' : ''; ?>>Open</option>
                    <option value="in-progress" <?php echo $ticket['status'] == 'in-progress' ? 'selected' : ''; ?>>In-
                        Progress</option>
                    <option value="resolved" <?php echo $ticket['status'] == 'resolved' ? 'selected' : ''; ?>>Resolved
                    </option>
                </select>
            </div>
            <div class="col-auto align-self-center">
                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5 start-0 end-0 bottom-0">
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