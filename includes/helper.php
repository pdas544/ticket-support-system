<?php

define ('ROOT', dirname(__DIR__));

define('DS', DIRECTORY_SEPARATOR);

str_replace('\\', '/', ROOT);

function loggedInUser():bool {
        
    return isset($_SESSION['user_id'])? true : false;
}