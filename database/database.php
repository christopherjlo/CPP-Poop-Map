<?php

$host = "poopmap-database.cdoxevnwyxjg.us-west-1.rds.amazonaws.com";
$dbname = "poopmap";
$username = "poopadmin";
$password = "pooplovers18593";

$conn = mysqli_connect($host, $username, $password, $dbname);

if ($conn->connect_errno) {
    die("Connection Error: " . $conn->connect_error);
}

return $conn;
?>