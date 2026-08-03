<?php
$password = "Sanatan@12#";

// Generate a bcrypt hash 
$hash = password_hash($password, PASSWORD_BCRYPT);

echo $hash;
?>
