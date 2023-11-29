<?php

$mysqli = require __DIR__ . "/database/database.php";

// $sql = sprintf("SELECT * FROM Pooper WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));
// $sql = sprintf("SELECT * FROM Pooper WHERE email = 'justin@gmail.com'");
$sql = sprintf("SELECT latitude, longitude, note FROM Poop where pooperid = 1;");

$result = $mysqli->query($sql);
$poop_coord_array = [];
while ($row = $result->fetch_assoc()) {
    // echo $row["latitude"], " ", $row["longitude"], "<br>";
    array_push($poop_coord_array, [$row["latitude"], $row["longitude"], $row['note']]);
}

// foreach ($poop_coord_array as $coordinate_pair) {
//     echo $coordinate_pair[0], "  ", $coordinate_pair[1], '<br>';
// }
?>

<html>
<div id="map"></div>
<button id="butt" type="button" onclick="initMap()">Refresh Map</button>
<div id ="coords"></div>
<head>
    <link rel = "stylesheet" href = "styles/index.css">
</head>
<script type="text/javascript" src="scripts/index.js"></script>
<script type ='text/javascript'>
    var passedArray =  <?php echo json_encode($poop_coord_array); ?>;  // convert PHP array into JS array
    setCoords(passedArray);               // calls setCoords method in index.js (to set locations array) before initMap is called
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS63jOsX26xQyOakRm6sCOZkU9voFkVaU&callback=initMap">
</script>
</html>