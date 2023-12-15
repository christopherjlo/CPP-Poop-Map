<?php

$mysqli = require __DIR__ . "/database/database.php";

// $sql = sprintf("SELECT * FROM Pooper WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));
// $sql = sprintf("SELECT * FROM Pooper WHERE email = 'justin@gmail.com'");
$sql = sprintf("SELECT latitude, longitude FROM Poop where pooperid = 1;");

$result = $mysqli->query($sql);

#gets data from entry with matching email. if email entered does not have matching entry in table,
#user will have nothing in it.
// $user = $result->fetch_assoc();
// $poops = $result->fetch_assoc();
$poop_coord_array = [];
while ($row = $result->fetch_assoc()) {
    // echo $row["latitude"], " ", $row["longitude"], "<br>";
    array_push($poop_coord_array, [$row["latitude"], $row["longitude"]]);
}

// foreach ($poop_coord_array as $coordinate_pair) {
//     echo $coordinate_pair[0], "  ", $coordinate_pair[1], '<br>';
// }

?>

<html>

<head>
    <title>User</title>
</head>
<script type='text/javascript' src="test.js"></script>
<script type='text/javascript'>
    var passedArray = <?php echo json_encode($poop_coord_array); ?>; // convert PHP array into JS array
    printCoords(passedArray);
</script>

<body>
    <p>
        Penissss
    </p>
    <div class>
        <?php
        // $coordinates = array(array(3434, 420), array(69, 69));
        // foreach ($coordinates as $coordinate){
        //     echo "$coordinate[0] $coordinate[1] <br>";
        // }

        // foreach ($user as $coordinatePair) {
        //     echo "$coordinatePair.gettype()";
        // }
        // 
        ?>

    </div>
</body>

</html>