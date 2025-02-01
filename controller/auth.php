<?php
session_start();
defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT','C:'.DS.'xampp'.DS.'htdocs'.DS.'ticket');

require_once SITE_ROOT.DS."db.php";

class Auth {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login($email, $password, $table = 'users') {
        // Validate table name
        // die("$email . $password . $table");

        // if (!in_array($table, ['users', 'agents'])) {
        //     $table = 'users';
        // }

        // $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //     header("Location: ../login-user.php?error=Invalid email format");
        //     exit();
        // }

        $stmt = $this->db->prepare("SELECT * FROM $table WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            header("Location: ../../login-user.php?error=User Not found");
            exit();
        }

        $dbUserPassword = $user['password'];
        $inputPassword = md5($password);

        if ($inputPassword === $dbUserPassword) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            if ($table === 'users') {
                if ($user['name'] === "admin") {
                    header("Location: ../admin/dashboard.php");
                } else {
                    header("Location: ../user/user-dashboard.php");
                }
            } else {
                header("Location: ../../agent/agent-dashboard.php");
            }
            exit();
        } else {
            header("Location: ../../login-user.php?error=Invalid Credentials");
            exit();
        }
    }
}

// Sanitize input and determine table
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../login-user.php?error=Invalid Email");
    exit();
}

$password = $_POST['password'];
$table=$_SESSION['table'];
$auth = new Auth($db);
$auth->login($email, $password, $table);