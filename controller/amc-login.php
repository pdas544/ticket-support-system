<?php
 
 /**
  * 
  *
  * @using auth.php for handling authentication
 */

// session_start();
// require_once '../db.php';

// class Auth {
//     private $db;

//     public function __construct($db) {
//         $this->db = $db;
//     }

//     public function login($email, $password) {
//         // Sanitize and validate input
//         $email = filter_var($email, FILTER_SANITIZE_EMAIL);
//         // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         //     header("Location: ../amc-login.php?error=Invalid email format");
//         //     exit();
//         // }

//         $stmt = $this->db->prepare("SELECT * FROM agents WHERE email = ?");
//         $stmt->bind_param("s", $email);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $user = $result->fetch_assoc();

//         $dbUserPassword = $user['password'];
//         $inputPassword = md5($password);
        

//         if ($inputPassword === $dbUserPassword) {
//             $_SESSION['user_id'] = $user['id'];
//             $_SESSION['user_name'] = $user['name'];
            
//             header("Location: ../agent/agent-dashboard.php");
            
//             exit();
//         } else {
//             header("Location: ../amc-login.php?error=Email ID or Password provided by you is incorrect. Please Try Again.");
//             exit();
//         }
//     }
// }

// // Sanitize and validate input before passing to the login method
// $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//     header("Location: login.html?error=Invalid email format");
//     exit();
// }

// $password = $_POST['password'];

// $auth = new Auth($db);
// $auth->login($email, $password);
?>