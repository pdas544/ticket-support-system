<?php


require_once '../ticketold/includes/initialize.php';

// die(SITE_ROOT);

require_once CONTROLLER_PATH.DS.'ticket.php';

require_once SITE_ROOT."\\db.php";

// var_dump($db);

// die();


if(isset($_GET['guest'])){
    $_SESSION['is_guest'] = $_GET['guest'];
    // die($_SESSION['is_guest']);
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // var_dump($_POST);
    // die();
    $name = htmlspecialchars($_POST['name']);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $description = htmlspecialchars($_POST['description']);
    $ticket = new Ticket($db);
    
    if($ticket->insertGuestTicket($name,$email,$subject,$description)==true){
        // die("success");
        header("Location: raise-ticket.php?createTicket=true&ticket_id=".$_SESSION['ticket_id']);
        exit();
    }else{
        header("Location: raise-ticket.php?createTicket=false");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raise Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include("includes/navbar.php") ?>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="raise-ticket-container d-flex flex-column justify-content-center">
            <h2 class="mb-4 text-center">Raise Ticket</h2>
            <form action="#" method="post" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="invalid-feedback">
                        Please provide your name.
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">
                        Please provide a valid email address.
                    </div>
                </div>


                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                    <div class="invalid-feedback">
                        Please provide the subject.
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    <div class="invalid-feedback">
                        Please provide the description.
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
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

    <!-- Footer -->


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        // JavaScript for disabling form submissions if there are invalid fields
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

        // Check for success message in URL and display modal if present
        $(document).ready(function () {
            var urlParams = new URLSearchParams(window.location.search);
            var createTicketMsg = urlParams.get('createTicket');
            var ticketId = urlParams.get('ticket_id');
            if (createTicketMsg === 'true') {
                $('#messageText').text('Ticket raised successfully. Your ticket ID is: ' + ticketId);
                $('#messageModal').modal('show');
            }
            if (createTicketMsg === 'false') {
                $('#messageText').text('Ticket Creation Failed.');
                $('#messageModal').modal('show');
            }

        });
    </script>
</body>

</html>