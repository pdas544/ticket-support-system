<?php
session_start();
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    date_default_timezone_set('Asia/Kolkata');
    $ticketIds = $_POST['ticket_id'];
    $updatedStatuses = $_POST['updated-status'];

    foreach ($ticketIds as $ticketId) {
        $updatedStatus = $updatedStatuses[$ticketId];
        $updatedAt = date("Y-m-d H:i:s");
        
        $stmt = $db->prepare("UPDATE guest_tickets SET status = ?,updated_at = ? WHERE id = ?");
        $stmt->bind_param("ssi", $updatedStatus,$updatedAt, $ticketId);
        $result = $stmt->execute();
    }

    if ($result) {
        $_SESSION['update_message'] = '<strong style="color: green;">Record updated successfully!</strong>';
    } else {
        $_SESSION['update_message'] = '<strong style="color: red;">Failed to update record.</strong>';
    }
    header("Location: guest-tickets.php");
    exit();
}

?>