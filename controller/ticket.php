<?php
session_start();

defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
	

defined('SITE_ROOT') ? null : define('SITE_ROOT','C:'.DS.'xampp'.DS.'htdocs'.DS.'ticket');


require_once SITE_ROOT.DS."db.php";
require_once SITE_ROOT.DS."controller".DS.'user.php';

// var_dump($db);

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


    public function updateTicketsTable($tableName="guest_tickets", $ticket_id){
        // Generate ticket ID
        $gen_ticket_id = "TKT1990" . $ticket_id;
        $_SESSION['ticket_id'] = $gen_ticket_id;
        // Update the guest tickets table with the generated ticket ID
        $stmt = $this->db->prepare("UPDATE $tableName SET ticket_id = ? WHERE id = ?");
        $stmt->bind_param("si", $gen_ticket_id, $ticket_id);
        try{
            $stmt->execute();
        }
        catch(Exception $e){
            die("Cannot update guest tickets table. Please contact Administrator" . $e->getMessage());
        }

        // Assign ticket to an available agent
        $this->assignTicket($tableName,$ticket_id);
    }

    public function insertTicket($user_id, $dept, $location, $subject, $description){
        $ticket_id="";
        $stmt = $this->db->prepare("INSERT INTO tickets (user_id,department,location,subject, description) VALUES (?, ?, ?,?,?)");
        $result = "";
        try{
            
            $stmt->bind_param("issss", $user_id, $dept, $location, $subject, $description);
            $result = $stmt->execute();
        }
        catch(Exception $e){
            die("Cannot create new ticket. Please contact Administrator: ".$e->getMessage());
        }
        $ticket_id = $stmt->insert_id;

        //assign it to an agent
        $this->assignTicket("tickets",$ticket_id);
        
       return $result;

    }

    public function insertGuestTicket($name, $email, $subject, $description){
        
        /**
         * 1) User::registerGuest() to insert guest user
         * 2) Check whether there is a logged in user and call function accordingly
         * 3) Assign ticket to an available agent
         * 4) Send the generated ticket id back to the calling page: raise-ticket.php
         */
        

        // Step-1: Insert guest user by calling registerGuest()
        $user = new User($this->db);
        $guest_user_id = $user->registerGuest($name, $email);
        $result=false;
        
        // Step-2: Insert guest ticket details
        $stmt = $this->db->prepare("INSERT INTO guest_tickets (user_id,subject, description) VALUES (?, ?, ?)");
        try{
            
            $stmt->bind_param("iss", $guest_user_id, $subject, $description);
            $result = $stmt->execute();
        }
        catch(Exception $e){
            die("Cannot create new ticket for guest. Please contact Administrator" . $e->getMessage());
        }

        $ticket_id = $stmt->insert_id;

        //Step-3: Assign ticket to an available agent
        $this->updateTicketsTable("guest_tickets", $ticket_id);

        return $result;

    }

    private function assignTicket($tableName="guest_tickets",$ticket_id) {
        // Fetch all agents
        $stmt = $this->db->prepare("SELECT id FROM agents");
        try{
            $stmt->execute();
            $agents = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        catch(Exception $e){
            die("Cannot fetch agents. Please contact Administrator" . $e->getMessage());
        }
        
        // Select a random agent
        $random_agent = $agents[array_rand($agents)];
        $agent_id = $random_agent['id'];

        // Assign ticket to the selected agent
        $stmt = $this->db->prepare("UPDATE {$tableName} SET agent_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $agent_id, $ticket_id);
        try{
            $stmt->execute();
        }
        catch(Exception $e){
            die("Cannot assign ticket to an agent. Please contact Administrator" . $e->getMessage());
        }
    }
 }


?>