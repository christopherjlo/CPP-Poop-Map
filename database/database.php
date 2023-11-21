<?php

$env = parse_ini_file('.env');

$host = $env["HOST"];
$dbname = $env["DB_NAME"];
$username = $env["USER_NAME"];
$password = $env["PASSWORD"];

$conn = mysqli_connect($host, $username, $password, $dbname);

if ($conn->connect_errno) {
    die("Connection Error: " . $conn->connect_error);
}

return $conn;
?>