<?php

defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
	
defined('SITE_ROOT') ? null : define('SITE_ROOT','C:'.DS.'xampp'.DS.'htdocs'.DS.'ticketold');

require_once SITE_ROOT.DS."db.php";

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * @param mixed $name, $email
     * @return int  $user_id
     * 
    */
    public function registerGuest($name, $email): int {
        
        $stmt = $this->db->prepare("INSERT INTO guest_users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $user_id = $stmt->insert_id;

        return $user_id;
    }

    public function register($name, $email, $password) {
        if ($this->emailExists($email)) {
            header("Location: register-user.php?error=email_exists");
            exit();
        }

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

?>