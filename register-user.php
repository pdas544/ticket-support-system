<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css">
  <style>
    .captcha {
      font-size: 24px;
      font-weight: bold;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-bottom: 10px;
      display: inline-block;
    }
  </style>

</head>

<body>
  <?php include("includes/navbar.php"); ?>

  <!-- Main Content -->
  <div class="container-fluid">
    <div class="register-container">
      <h2 class="mb-4 text-center">Register</h2>
      <form action="controller/register.php" method="post" class="needs-validation" novalidate>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name" required />
          <div class="invalid-feedback">Please provide your name.</div>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" required />
          <div class="invalid-feedback">
            Please provide a valid email address.
          </div>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" required
            title='Min length:5, Min Uppercase:1,Min Lowercase:1,Min Special Character:1, Min Digit:1' />
          <div class="invalid-feedback">Please provide a valid password.</div>
          <small id="passwordHelp" class="form-text text-danger">Min length:5, Min Uppercase:1,Min Lowercase:1,Min
            Special Character:1, Min Digit:1</small>
        </div>
        <div class="form-group">
          <label for="confirm_password">Confirm Password</label>
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" required />
          <div class="invalid-feedback">Please confirm your password.</div>
        </div>
        <div class="form-group mt-2">
          <label for="captcha">Captcha</label>
          <div class="captcha" id="captcha">Loading...</div>
          <input type="text" class="form-control" id="captcha_input" name="captcha_input" required />
          <div class="invalid-feedback">
            Please enter the correct captcha.
          </div>
        </div>
        <div class="mx-auto" style="width:100px;">
          <button type="submit" class="btn btn-primary mt-2">
            Register
          </button>
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
  <script>
    $(function () {
      $("#passwordHelp").hide();
    });
    $("#password").on("focus", function () {
      $("#passwordHelp").css("display", "inline").slideUp(3000);
    });

    (function () {
      "use strict";
      window.addEventListener(
        "load",
        function () {

          var forms = document.getElementsByClassName("needs-validation");
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(
            forms,
            function (form) {
              form.addEventListener(
                "submit",
                function (event) {
                  if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                  }
                  form.classList.add("was-validated");
                },
                false
              );
            }
          );
        },
        false
      );
    })();

    // Generate random captcha
    function generateCaptcha() {
      var chars =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      var captcha = "";
      for (var i = 0; i < 6; i++) {
        captcha += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      return captcha;
    }
    //Set captcha on page load 
    document.getElementById("captcha").innerText = generateCaptcha();
    // Validate form before submission 
    document.querySelector("form").addEventListener("submit", function (event) {
      var
        password = document.getElementById("password").value;
      var
        confirmPassword = document.getElementById("confirm_password").value;
      var
        captchaInput = document.getElementById("captcha_input").value;
      var
        captcha = document.getElementById("captcha").innerText;
      if (password !== confirmPassword) {
        event.preventDefault();
        alert("Password and Confirm Password do not match.");
      } else if (captchaInput !== captcha) {
        event.preventDefault();
        alert("Captcha does not match.");
      } else if (!validatePassword(password)) {
        event.preventDefault();
        alert("Password does not meet the requirements.");
      }
    });

    // Check for message in URL and display modal if present
    $(document).ready(function () {
      var urlParams = new URLSearchParams(window.location.search);
      var
        errorMessage = urlParams.get("error");
      var successMessage = urlParams.get("success");
      if (errorMessage === "email_exists") {
        $("#messageText").text("Email already exists, Kindly Sign-In.");
        $("#messageModal").modal("show");
      } else if (successMessage === "true") {
        $("#messageText").text("Registered successfully.");
        $("#messageModal").modal("show");
      }
    });

    // Password validation function
    function validatePassword(password) {
      const pattern = new RegExp('^(?=.*\\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\\w\\d\\s:])([^\\s]){5,}$');

      return pattern.test(password);
    }
  </script>
</body>

</html>