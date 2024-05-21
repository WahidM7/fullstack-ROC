<?php

include 'connect.php';

// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();


if(isset($_COOKIE['user'])):
    setcookie('user', '', time()-7000000, '/');
endif;

// Finally, destroy the session.
session_destroy();

header('location:../index.php');

?>