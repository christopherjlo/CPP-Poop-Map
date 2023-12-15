<?php

session_start();

$userid = $latitude = $longitude = $tag = $note = $timestamp = null;

if (isset($_SESSION["currentID"])) {
    $userid = $_SESSION["currentID"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"])) {

        $latitude = $_POST["latitude"];
        $longitude = $_POST["longitude"];
        $tag = $_POST["tag"];
        $note = $_POST["note"];
        $datestamp = $_POST["datestamp"];
        $timestamp = $_POST["timestamp"];

        // if tag/location and note/description is empty. Just put null value in record
        if (empty($tag)) {
            $tag = "";
        }
        if (empty($note)) {
            $note = "";
        }

        // convert latitude and longitude values into doubles
        $latitude = floatval($latitude);
        $longitude = floatval($longitude);

        // insert record into Poop table
        $mysqli = require __DIR__ . "/database/database.php";
        $sql = "INSERT INTO Poop(pooperid, latitude, longitude, tag, datePosted, timePosted, note)
        VALUES(?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = $mysqli->stmt_init();

        if (!$stmt2->prepare($sql)) {
            die("SQL Error: " .  $mysqli->error);
        }
        $stmt2->bind_param("sssssss", $userid, $latitude, $longitude, $tag, $datestamp, $timestamp, $note);
        $stmt2->execute();
    }
}
?>

<html>

<head>
    <title>Poop Creation</title>
    <link rel="stylesheet" href="styles/poop_details.css">
</head>

<body>
    <div class="background">
        <img src="/images/poop_pic.png" class="logo">
        <div class=poop-form>
            <h1>New Poop</h1>
            <form id="form" method="post">
                <p class="title">Date</p><br>
                <input type="text" id="datestamp" name="datestamp">
                <p class="title">Time</p><br>
                <input type="text" id="timestamp" name="timestamp"><br><br>

                <!-- <p id="show_coords"></p> -->
                <input type="text" name="latitude" id="latitude_field">
                <input type="text" name="longitude" id="longitude_field">

                <p class="title">Location (optional)</p><br>
                <input type="text" name="tag" class="input blue-border" placeholder=" Enter location"><br>

                <p class="title">Description (optional)</p><br>
                <input type="text" name="note" class="input blue-border" placeholder=" Enter description"><br>
                <input class="button borderless" type="submit" name="submit" value="Save" id="submit">
            </form>
            <a href="home.php"><button class="button borderless">Back</button></a>
        </div>
        <a href="home.php"><button class="back_button borderless">Back</button></a>
        <script type="text/javascript">
            // ---- Get and display current date + time ---- //
            var date = new Date();
            var year = date.getFullYear().toString();
            var currentDate = date.getDate() + "/" + (date.getMonth() + 1) + "/" + year.substr(2);
            var currentTime = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
            document.getElementById("datestamp").value = currentDate;
            document.getElementById("timestamp").value = currentTime;

            // ---- Get and display coordinates ---- //
            const coord_p = document.getElementById("show_coords"); //for testing/display
            var lat = document.getElementById("latitude_field");
            var long = document.getElementById("longitude_field");

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    coord_p.innerHTML = "Geolocation is not supported by this browser.";
                }
            }

            function showPosition(position) {
                lat.value = position.coords.latitude;
                long.value = position.coords.longitude;

                // coord_p.innerHTML = "Latitude: " + position.coords.latitude +       //for testing/display
                // "<br>Longitude: " + position.coords.longitude;
            }
            getLocation();
        </script>
    </div>
</body>

</html>