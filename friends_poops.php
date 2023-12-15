<?php
$env = parse_ini_file('.env');
$key = $env["API_KEY"];
$apiCallString = "https://maps.googleapis.com/maps/api/js?key=" . $key . "&callback=initMap";

session_start();

if (isset($_SESSION["currentID"])) {
    $mysqli = require __DIR__ . "/database/database.php";

    $stmt = sprintf("SELECT *  FROM Friends WHERE usr1id = " . $_SESSION["currentID"]);
    $result = $mysqli->query($stmt);

    $realFriends = []; // list of all your friends
    while ($row = $result->fetch_assoc()) {

        $stmt2 = sprintf("SELECT * FROM Friends WHERE usr1id = " . $row['usr2id'] . " AND usr2id = " . $_SESSION["currentID"]);
        $result2 = $mysqli->query($stmt2);
        $friend = $result2->fetch_assoc();

        if (!empty($friend)) {
            array_push($realFriends, $friend['usr1id']);
        }
    }

    $sql = sprintf("SELECT Pooper.userid, Poop.latitude, Poop.longitude, Poop.tag, Poop.note, Poop.datePosted, Pooper.fName, Pooper.lName 
    FROM Poop
    INNER JOIN Pooper ON Poop.pooperid=Pooper.userid;");

    $result = $mysqli->query($sql);
    $poop_coord_array = [];
    while ($row = $result->fetch_assoc()) {
        if (in_array($row['userid'], $realFriends)) {
            if ($row['userid'] == $_SESSION["currentID"]) {
                array_push($poop_coord_array, [$row["latitude"], $row["longitude"], $row['tag'], $row['note'], $row['datePosted'], false, $row['fName'], $row['lName']]);
            } else {
                array_push($poop_coord_array, [$row["latitude"], $row["longitude"], $row['tag'], $row['note'], $row['datePosted'], true, $row['fName'], $row['lName']]);
            }
        }
    }
} else {echo("<h1 style='text-align:center'> Nothing to see here, please login or create an account </h1>");}
?>

<html>

<head>
    <link rel="stylesheet" href="styles/friends_poops.css">
</head>

<body>
    <div id="outer_div">
        <div id="map"></div>
        <a href="index.php"><button id="back_button" class="button">Back</button></a>
<!-- 
        <form method="post" action="logout.php">
            <a href="home.html"><input type ="submit" id="sign_out_button" name="sign_out_button" class="button" value="Sign Out"/></a>
        </form> -->

    </div>
    <script type="text/javascript" src="scripts/friends_poops.js"></script>
    <script type='text/javascript'>
        var passedArray = <?php echo json_encode($poop_coord_array); ?>; // convert PHP array into JS array
        setCoords(passedArray); // calls setCoords method in index.js (to set locations array) before initMap is called
    </script>
    <script async defer src=<?php echo $apiCallString ?>>
    </script>
</body>

</html>