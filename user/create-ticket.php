<?php
// session_start();
require_once '../includes/initialize.php';

require_once CONTROLLER_PATH.DS.'ticket.php';

require_once SITE_ROOT."\\db.php";

if(!isset($_SESSION['user_name'])){
    header("Location: ../login-user.php");
    exit();
 }

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $department = htmlspecialchars($_POST['department']);
    $location = htmlspecialchars($_POST['location']);
    $subject = htmlspecialchars($_POST['subject']);
    $description = htmlspecialchars($_POST['description']);
    $ticket = new Ticket($db);
    if($ticket->insertTicket($_SESSION['user_id'],$department,$location,$subject,$description)==true){
        header("Location: user-dashboard.php?createTicket=true");
        exit();
    }else{
        header("Location: user-dashboard.php?createTicket=false");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
        <a class="navbar-brand" href="user_dashboard.php">User Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link"><strong>Welcome,
                            <?php echo $_SESSION['user_name'] ?? ""; ?></strong></span>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="user-dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create-ticket.php">Create Ticket</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="../controller/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container mt-5">
        <div class="login-container">
            <h2 class="text-center">Raise Ticket</h2>
            <form action="create-ticket.php" method="post">
                <div class="form-group">
                    <label for="department">Department</label>
                    <select name="department" id="" class="form-select" aria-label="Default select example">
                        <option value="" selected disabled>--Select Department--</option>
                        <option value="fc">Fashion Communication</option>
                        <option value="ft">Fashion Technology</option>
                        <option value="fd">Fashion Design</option>
                        <option value="fla">Fashion and LifeStyle Accessories</option>
                        <option value="td">Textile Design</option>
                        <option value="fm">Fashion Management</option>
                        <option value="et">Establishment</option>
                        <option value="ac">Accounts</option>
                        <option value="ad">Administration</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required
                        placeholder="Enter Issue location (classroom/lab/etc)">
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required
                        placeholder="Enter brief subject">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required
                        placeholder="Enter brief description"></textarea>
                </div>
                <div class="w-25 mx-auto">
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <p id="messageText"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>