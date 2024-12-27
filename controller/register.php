<?php
session_start();
require_once '../db.php';

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($name, $email, $password) {
        
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        return $stmt->execute();
    }

    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}

// Sanitize and validate input
$name = htmlspecialchars($_POST['name']);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}
$password = md5($_POST['password']);

$user = new User($db);

if ($user->emailExists($email)) {
    header("Location: ../register-user.php?error=email_exists");
    exit();
} else {
    $user->register($name, $email, $password);
    header("Location: ../register-user.php?success=true");
    exit();
}
?>