<?php
session_start();
// require './bootstrap.php';
require_once 'db.php';
require_once 'controller/user.php';

$user = new User($db);

if($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Sanitize and validate input
  $name = htmlspecialchars($_POST['name']);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $password = md5($_POST['password']);

  if($user->register($name, $email, $password)==true) {
    header("Location: register-user.php?register=true");
    exit();
  }else{
    header("Location: register-user.php?register=false");
    exit();
  }

  // die("register page died");
}

?>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    /* .captcha {
      font-size: 24px;
      font-weight: bold;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-bottom: 10px;
      display: inline-block;
    } */

    .captcha-container {
      /* margin: 20px; */
      /* padding: 10px; */
      /* background: #f0f0f0; */
      /* display: inline-block; */
    }

    #captchaImage {
      border: 1px solid #ccc;
      /*margin: 10px 0; */
    }

    .refresh-btn {
      /* display: inline-block;
      cursor: pointer;
      color: blue;
      text-decoration: underline; */
      cursor: pointer;
    }
  </style>

</head>

<body>
  <?php include("includes/navbar.php"); ?>

  <!-- Main Content -->
  <div class="container-fluid">
    <div class="register-container">
      <h2 class="mb-4 text-center">Register</h2>
      <form action="register-user.php" method="post" class="needs-validation" novalidate>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter your Name" required />
          <div class="invalid-feedback">Please provide your name.</div>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" pattern="^[a-zA-Z0-9._%+-]+@nift\.ac\.in$"
            placeholder="Use NIFT Email ID" required />
          <div class="invalid-feedback">
            Please provide a valid NIFT Email ID.
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
        <div class="form-group captcha-container d-flex flex-column">
          <div class="d-inline-flex mt-3 mb-3 justify-content-center gap-2">
            <!-- <label for="captcha">Captcha</label> -->
            <canvas class="" id="captchaImage" width="200" height="60"></canvas>

            <div class="fs-3 align-self-center refresh-btn" id="captcha" onclick="generateImageCaptcha()"><i
                class="fa fa-refresh" aria-hidden="true"></i></div>
          </div>
          <input type="text" class="form-control" id="captchaInput" placeholder="Enter CAPTCHA" required />
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
      $("#passwordHelp").css("display", "inline"); //display static message
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
    let currentCaptcha = '';

    function generateCaptcha() {
      const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      let captcha = '';
      for (let i = 0; i < 6; i++) {
        captcha += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      return captcha;
    }

    function generateImageCaptcha() {
      const canvas = document.getElementById('captchaImage');
      const ctx = canvas.getContext('2d');

      // Clear canvas
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      // Generate new CAPTCHA
      currentCaptcha = generateCaptcha();

      // Add background noise
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      // Add random lines
      for (let i = 0; i < 5; i++) {
        ctx.strokeStyle = `rgb(${Math.random() * 255},${Math.random() * 255},${Math.random() * 255})`;
        ctx.beginPath();
        ctx.moveTo(Math.random() * canvas.width, Math.random() * canvas.height);
        ctx.lineTo(Math.random() * canvas.width, Math.random() * canvas.height);
        ctx.stroke();
      }

      // Draw CAPTCHA text
      ctx.font = '30px Arial';
      ctx.fillStyle = '#000000';
      for (let i = 0; i < currentCaptcha.length; i++) {
        ctx.save();
        ctx.translate(30 + i * 25, 40);
        ctx.rotate((Math.random() - 0.5) * 0.4);
        ctx.fillText(currentCaptcha[i], 0, 0);
        ctx.restore();
      }

      // Add random dots
      for (let i = 0; i < 50; i++) {
        ctx.fillStyle = `rgba(${Math.random() * 255},${Math.random() * 255},${Math.random() * 255},0.5)`;
        ctx.beginPath();
        ctx.arc(
          Math.random() * canvas.width,
          Math.random() * canvas.height,
          Math.random() * 2,
          0,
          2 * Math.PI
        );
        ctx.fill();
      }
    }

    function validateCaptcha() {
      const userInput = document.getElementById('captchaInput').value;

      if (userInput === currentCaptcha) {
        return true;
      } else {

        generateImageCaptcha();
        document.getElementById('captchaInput').value = '';

      }
      return false;
    }

    // Generate initial CAPTCHA on page load
    generateImageCaptcha();

    // Validate form before submission 
    document.querySelector("form").addEventListener("submit", function (event) {
      var
        password = document.getElementById("password").value;
      var
        confirmPassword = document.getElementById("confirm_password").value;
      // var captchaInput = document.getElementById("captchaInput").value;
      var
        captcha = document.getElementById("captcha").innerText;
      if (password !== confirmPassword) {
        event.preventDefault();
        alert("Password and Confirm Password do not match.");
      } else if (validateCaptcha() == false) {
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
      var errorMessage = urlParams.get("error");
      var registerMessage = urlParams.get("register");
      if (errorMessage === "email_exists") {
        $("#messageText").text("Email already exists, Kindly Sign-In.");
        $("#messageModal").modal("show");
      }
      if (registerMessage === "true") {
        $("#messageText").text("Registered successfully.");
        $("#messageModal").modal("show");
      }
      if (registerMessage === "false") {
        $("#messageText").text("Registration Failed. Kindly, try again!");
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