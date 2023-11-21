
<?php
session_start();

if (isset($_SESSION["currentID"])) {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM Pooper WHERE userid = {$_SESSION["currentID"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    // $sql = "SELECT * FROM preference WHERE acct_id = {$_SESSION["currentID"]}";
    // $result2 = $mysqli->query($sql);
    // $userPreferences = $result2->fetch_assoc();

    // $sql = "SELECT * FROM images WHERE id = {$_SESSION["currentID"]}";
    // $result1 = $mysqli->query($sql);
    // $result = $result1->fetch_assoc();
}
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