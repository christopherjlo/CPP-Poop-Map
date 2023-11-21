<?php

$env = parse_ini_file('.env');

print($env['HOST']);

$host = "poopmap-database.cdoxevnwyxjg.us-west-1.rds.amazonaws.com"; # $env["HOST"];
$dbname = "poopmap"; #$env["DB_NAME"];
$username = "poopadmin"; #$env["USER_NAME"];
$password = "pooplovers18593"; #$env["PASSWORD"];

$conn = mysqli_connect($host, $username, $password, $dbname);

if ($conn->connect_errno) {
    die("Connection Error: " . $conn->connect_error);
}

return $conn;
?>