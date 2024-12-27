<?php
session_start();
require_once '../db.php';

class Ticket {
    private $db;
    

    /**
     * Constructor
     *
     * @param object $db The database object
     */
    public function __construct($db) {
        $this->db = $db;
        
    }

    public function create($user_id, $name, $email, $subject, $description) {
        // Insert user's name and email into the users table
        $stmt = $this->db->prepare("INSERT INTO guest_users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $user_id = $stmt->insert_id;

        // Insert ticket details into the tickets table
        
        try{
        $stmt = $this->db->prepare("INSERT INTO guest_tickets (user_id,subject, description) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $subject, $description);
        $stmt->execute();
        }
        catch(Exception $e){
            die("Error in Query: " . $e->getMessage());
        }

        $ticket_id = $stmt->insert_id;

        // Generate ticket ID
        $ticket_id_str = "TKT1990" . $ticket_id;

        // Update the tickets table with the generated ticket ID
        $stmt = $this->db->prepare("UPDATE guest_tickets SET ticket_id = ? WHERE id = ?");
        $stmt->bind_param("si", $ticket_id_str, $ticket_id);
        $stmt->execute();

        // Assign ticket to an available agent
        $this->assignTicket($ticket_id);

        // Redirect to raise-ticket.php with success message and ticket ID
        header("Location: ../raise-ticket.php?success=true&ticket_id=" . urlencode($ticket_id_str));
        exit();
    }

    private function assignTicket($ticket_id) {
        // Fetch all agents
        $stmt = $this->db->prepare("SELECT id FROM agents");
        $stmt->execute();
        $result = $stmt->get_result();
        $agents = $result->fetch_all(MYSQLI_ASSOC);

        // Select a random agent
        $random_agent = $agents[array_rand($agents)];
        $agent_id = $random_agent['id'];

        // Assign ticket to the selected agent
        $stmt = $this->db->prepare("UPDATE guest_tickets SET agent_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $agent_id, $ticket_id);
        $stmt->execute();
    }
}

// Sanitize and validate input
$name = htmlspecialchars($_POST['name']);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../raise-ticket.php?Invalid email format");
}

$subject = htmlspecialchars($_POST['subject']);
$description = htmlspecialchars($_POST['description']);

$ticket = new Ticket($db);
$ticket->create(null, $name, $email, $subject, $description);
?>