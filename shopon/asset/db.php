<?php

$username = 'root';
$password = '';
$connection = new PDO( 'mysql:host=localhost;dbname=db', $username, $password );
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
date_default_timezone_set("Asia/Kolkata"); 

?>