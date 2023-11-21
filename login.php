<?php
$is_invalid = false;
$errmsg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database/database.php";

    $sql = sprintf("SELECT * FROM Pooper WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    #gets data from entry with matching email. if email entered does not have matching entry in table,
    #user will have nothing in it.
    $user = $result->fetch_assoc();

    #if user has stuff in it, now we check if the password they entered matches up
    if ($user) {

       if (password_verify($_POST["password"], $user["passwordHash"])) {
            session_start();

            $_SESSION["currentID"] = $user["userid"];

            $query = "SELECT * FROM Pooper WHERE userid = '{$_SESSION["currentID"]}'";
            $result = $mysqli->query($query);
            $row = $result->fetch_assoc();

            header("Location: index.php");

            // if ($row['clean'] == "") {
            //     header("Location: moreInfo.php");
            // } else {
            //     header("Location: index.php");
            // }

            exit;
        } else {
            $errmsg = "Incorrect Password!";
            $is_invalid = true;
        }
    } else {
        $errmsg = "Email address doesn't exist!";
        $is_invalid = true;
    }
}
?>


<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
</head>

<body>
    <img src="/images/poop_pic.png" class="logo">
    <p class = "poop_title" href = "" > Poop Map </h1>
    <div class=login-form>
        <h1>Log in</h1>
        <div id="error" class="error">
            <?php
            if ($is_invalid) {
                echo "<p class='error'>", $errmsg, "</p>";
            } ?>
        </div>
        <form id="form" method="post">
            <p class="title">Email:</p><br>
            <input type="email" name="email" class="input blue-border" placeholder=" Enter Email"><br>
            <p class="title">Password:</p><br>
            <input type="password" name="password" class="input blue-border" placeholder=" Enter Password..."><br>
            <input class="button borderless" type="submit" value="LOGIN" />
        </form>
        <img src="/images/poop_marker.png" id="poop_marker_logo">
        <h2 class="small" style="margin-top: 1%; color: black;">Don't have an account? <a id="create">Create one here!</a></h2>
    </div>
</body>
</html>