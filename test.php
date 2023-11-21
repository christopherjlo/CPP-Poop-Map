<?php

$mysqli = require __DIR__ . "/database/database.php";

// $sql = sprintf("SELECT * FROM Pooper WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));
$sql = sprintf("SELECT * FROM Pooper WHERE email = 'justin@gmail.com'");

$result = $mysqli->query($sql);

#gets data from entry with matching email. if email entered does not have matching entry in table,
#user will have nothing in it.
$user = $result->fetch_assoc();
?>

<html>
<head>
    <title>User</title>
</head>

<body>
    <div class>
        <p class>Hello <?= $user["fName"] ?>!</p>
    </div>
</body>

</html>