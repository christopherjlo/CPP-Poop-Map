<?php
$is_invalid = false;
$errmsg = "";

# Input validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $fname = $_POST["fName"];
    $lname = $_POST["lName"];
    $password = $_POST["password"];
    $cpassword = $_POST["password_confirmation"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $errmsg = $emailErr;
        $is_invalid = true;
    }

    else if (empty($fname)) {
        $fnameErr = "Please enter your first name";
        $errmsg = $fnameErr;
        $is_invalid = true;
    }

    else if (empty($lname)) {
    $lnameErr = "Please enter your last name";
    $errmsg = $lnameErr;
    $is_invalid = true;
    }

    else if (empty($password)) {
        $passwordErr = "Please enter your password";
        $errmsg = $passwordErr;
        $is_invalid = true;
    }

    else if ($password != $cpassword) {
        $passwordCErr = "Passwords do not match";
        $errmsg = $passwordCErr;
        $is_invalid = true;
    }
    else {
        $mysqli = require __DIR__ . "/database/database.php";

        # Email validation
        $query = "SELECT * FROM pooper WHERE email = '" . $email . "'";

        $result = $mysqli->query($query);

        if ($result->fetch_assoc()) {
            # Email already exists
            $is_invalid = true;
            $errmsg = "Email address taken!";
        }
        else {
            # Add new entry to pooper
            $sql = "INSERT INTO pooper(fName, lName, email, passwordHash)
            VALUES (?, ?, ?, ?)";
            
            $stmt = $mysqli->stmt_init();
    
            if(!$stmt->prepare($sql)) {
                die("SQL error: " . $mysqli->error);
            }

            $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);
            
            $stmt->bind_param("ssss", $_POST["fName"], $_POST["lName"], $_POST["email"], $passwordHash);
    
            $stmt->execute();

            header("Location: signup-success.html");
        }
    }
}

?>

<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="styles/signup.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
</head>

<body>
    <!-- <img src="images/poop_pic.png" class="logo"> -->
    <p class = "poop_title" href = "" > Poop Map </h1>
    <div class=login-form>
        <h1>Sign up</h1>
        <div id="error" class="error">
            <?php
            if ($is_invalid) {
                echo "<p class='error'>", $errmsg, "</p>";
            } ?>
        </div>
        <form id="form" method = "post">
            <p class="title">Email:</p><br>
            <input type="email" name="email" class="input blue-border" placeholder=" Enter Email"><br>

            <p class="title">First name:</p><br>
            <input type="text" name="fName" class="input blue-border" placeholder=" Enter First name"><br>

            <p class="title">Last name:</p><br>
            <input type="text" name="lName" class="input blue-border" placeholder=" Enter Last name"><br>

            <p class="title">Password:</p><br>
            <input type="password" name="password" class="input blue-border" placeholder=" Enter Password"><br>

            <p class="title">Password confirmation:</p><br>
            <input type="password" name="password_confirmation" class="input blue-border" placeholder=" Confirm Password"><br>

            <input class="button borderless" type="submit" value="Sign up" />
        </form>
        <img src="images/poop_pic.png" id="poop_marker_logo">
    </div>
    <a href="home.html"><button class="back_button">Back</button></a>
</body>
</html>