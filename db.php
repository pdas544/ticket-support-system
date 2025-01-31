<?php
$db = new mysqli("localhost", "root", "Root@123", "ticketing_support");


try{
    if($db->connect_error);
    
}catch(Exception $e){
    echo "Connection failed: " . $e->getMessage();
}
?>