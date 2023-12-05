<?php
$env = parse_ini_file('.env');
$key = $env["API_KEY"];
$apiCallString = "https://maps.googleapis.com/maps/api/js?key=" . $key . "&callback=initMap";

session_start();

if (isset($_SESSION["currentID"])) {
    $mysqli = require __DIR__ . "/database/database.php";
    $sql = sprintf("SELECT latitude, longitude, tag, note, datePosted FROM Poop where pooperid = {$_SESSION["currentID"]};");

    $result = $mysqli->query($sql);
    $poop_coord_array = [];
    while ($row = $result->fetch_assoc()) {
        // echo $row["latitude"], " ", $row["longitude"], "<br>";
        array_push($poop_coord_array, [$row["latitude"], $row["longitude"], $row['tag'], $row['note'], $row['datePosted']]);
    }
}

// $mysqli = require __DIR__ . "/database/database.php";

// $sql = sprintf("SELECT * FROM Pooper WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));
// $sql = sprintf("SELECT * FROM Pooper WHERE email = 'justin@gmail.com'");
// $sql = sprintf("SELECT latitude, longitude, note FROM Poop where pooperid = 1;");

// foreach ($poop_coord_array as $coordinate_pair) {
//     echo $coordinate_pair[0], "  ", $coordinate_pair[1], '<br>';
// }
?>

<html>
<head>
    <link rel = "stylesheet" href = "styles/index.css">
</head>
<body>
    <div id="map"></div>
    <a href="poop_details.php"><button id = "poop_button" >Drop poop</button></a>
    <script type="text/javascript" src="scripts/index.js"></script>
        <script type ='text/javascript'>
            var passedArray =  <?php echo json_encode($poop_coord_array); ?>;  // convert PHP array into JS array
            setCoords(passedArray);               // calls setCoords method in index.js (to set locations array) before initMap is called
        </script>
        <script async defer
            src=<?php echo $apiCallString ?>>
        </script>
</body>
</html>