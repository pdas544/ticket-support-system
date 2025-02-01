<?php
$db = new mysqli("localhost", "root", "", "ticketing_support");


try{
    if($db->connect_error);
    
}catch(Exception $e){
    echo "Connection failed: " . $e->getMessage();
}
?>