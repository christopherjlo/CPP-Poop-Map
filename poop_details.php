<?php

session_start();

$userid = $latitude = $longitude = $tag = $note = $timestamp = null;
$yuh = null;

if (isset($_SESSION["currentID"])) {
    $userid = $_SESSION["currentID"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"])) {
        $yuh = true;

        $latitude = $_POST["latitude"];
        $longitude = $_POST["longitude"];
        $tag = $_POST["tag"];
        $note = $_POST["note"];
        $timestamp = $_POST["timestamp"];

        // if tag/location and note/description is empty. Just put null value in record
        if (empty($tag)) {
            $tag = "NULL";
        }
        if (empty($note)) {
            $note = "NULL";
        }

        // convert latitude and longitude values into doubles
        $latitude = floatval($latitude);
        $longitude = floatval($longitude);

        // insert record into Poop table
        $mysqli = require __DIR__ . "/database/database.php";
        $sql = "INSERT INTO Poop(pooperid, latitude, longitude, tag, timePosted, note)
        VALUES(?, ?, ?, ?, ?, ?)";
        $stmt2 = $mysqli->stmt_init();

        if (!$stmt2->prepare($sql)) {
            die("SQL Error: " .  $mysqli->error);
        }
        $stmt2->bind_param("ssssss", $userid, $latitude, $longitude, $tag, $timestamp, $note);
        $stmt2->execute();
    }
}
?>

<html>
    <head>
        <title>Poop Creation</title>
    </head>
    <body>
        <h1>New Poop</h1>
        <?php
        if ($yuh) {
            echo $userid, "<br>";
            echo $latitude, "<br>";
            echo $longitude, "<br>";
            echo $tag, "<br>";
            echo $note, "<br>";
            echo $timestamp, "<br>";
        } ?>        
        <form id="form" method="post">
            <p>Date and time</p>
            <p><span id = "datestamp_ptag"></span></p>
            <p><span id = "timestamp_ptag"></span></p>
            <input type = "text" id = "timestamp" name = "timestamp">

            <p id="show_coords"></p>
            <input type = "text" name = "latitude" id = "latitude_field">
            <input type = "text" name = "longitude" id = "longitude_field">

            <p>Tag location (optional)</p>
            <input type="text" name="tag" placeholder="Enter location"><br>

            <p>Description (optional)</p>
            <input type="text" name="note" placeholder="Enter description"><br>
            <input type="submit" name="submit" value="Save" id="submit">
        </form>

        <button onclick="getLocation()">Show Coords</button>
        <a href="index.php"><button class="button">Back</button></a>

        <script type="text/javascript">
            // ---- Displaying current date + time ---- //
            var date = new Date();
            var currentDate = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
            var currentTime = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
            document.getElementById("datestamp_ptag").innerHTML = currentDate;  //for testing/display
            document.getElementById("timestamp_ptag").innerHTML = currentTime;  //for testing/display
            document.getElementById("timestamp").value = currentTime;

            // ---- Getting coordinates ---- //
            const coord_p = document.getElementById("show_coords");             //for testing/display
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

                coord_p.innerHTML = "Latitude: " + position.coords.latitude +       //for testing/display
                "<br>Longitude: " + position.coords.longitude;
            }  
        </script>
    </body>
</html>