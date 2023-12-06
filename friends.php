<?php

$_SESSION["currentID"] = 2;

if (isset($_SESSION["currentID"])) {
    $mysqli5 = require __DIR__ . "/database/database.php";

    $stmt5 = sprintf("SELECT *  FROM Friends WHERE usr1id = " . $_SESSION["currentID"]);
    $result5 = $mysqli5->query($stmt5);

    $realFriends = [];
    while ($row = $result5->fetch_assoc()) {

        $sql = sprintf("SELECT * FROM Friends WHERE usr1id = " . $row['usr2id'] . " AND usr2id = " . $_SESSION["currentID"]);
        $result6 = $mysqli5->query($sql);
        $friend = $result6->fetch_assoc();

        if (!empty($friend)) {
            array_push($realFriends, $friend['usr1id']);
        }
    }

    // print_r($realFriends);
    if (sizeof($realFriends) == 0) {
        echo "No friends.";
    } else {
        for ($i = 0; $i < sizeof($realFriends); $i++) {
            $stmt5 = sprintf("SELECT *  FROM Pooper WHERE userid = " . $realFriends[$i]);
            $result5 = $mysqli5->query($stmt5);
            $users = $result5->fetch_assoc();

            echo $users['fName'];
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database/database.php";

    $sql = sprintf("SELECT * FROM Pooper WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if (empty($user)) {
        echo 'User not found';
    } else {
        $currentID = $_SESSION["currentID"]; // change later
        $searchedID = $user['userid'];

        if ($currentID == $searchedID) {
            echo "Unforunately, you can't friend yourself :(";
        } else {
            $currentFriendedToSearched = False;

            // check if current is friended with searched
            $sql2 = sprintf("SELECT * FROM Friends WHERE usr1id = " . $currentID);
            $result2 = $mysqli->query($sql2);
            while ($row2 = $result2->fetch_assoc()) {
                if ($row2['usr2id'] == $searchedID) {
                    $currentFriendedToSearched = True;
                }
            }

            if ($currentFriendedToSearched == True) {
                echo 'You are already friended with this person,';
            } else {
                $sql4 = sprintf("INSERT INTO Friends (usr1id, usr2id) values(" . $currentID . ", " . $searchedID . ')');
                $mysqli->query($sql4);
                echo 'You have friended this person,';
            }

            echo "";

            // check if searched is friended with current

            $searchedFriendedtoCurrent = False;

            $sql3 = sprintf("SELECT * FROM Friends WHERE usr1id = " . $searchedID);
            $result3 = $mysqli->query($sql3);
            while ($row3 = $result3->fetch_assoc()) {
                if ($row3['usr2id'] == $currentID) {
                    $searchedFriendedtoCurrent = True;
                }
            }

            if ($searchedFriendedtoCurrent == True) {
                echo ' and they have you friended as well!';
            } else {
                echo ' but they have not friended you yet!';
            }

            if ($currentFriendedToSearched == True && $searchedFriendedtoCurrent == True) {
                echo '     TRUE FRIENDS FOUND';
            }
        }
    }

    if (isset($_SESSION["currentID"])) {
        $mysqli5 = require __DIR__ . "/database/database.php";

        $stmt5 = sprintf("SELECT *  FROM Friends WHERE usr1id = " . $_SESSION["currentID"]);
        $result5 = $mysqli5->query($stmt5);

        $realFriends = [];
        while ($row = $result5->fetch_assoc()) {

            $sql = sprintf("SELECT * FROM Friends WHERE usr1id = " . $row['usr2id'] . " AND usr2id = " . $_SESSION["currentID"]);
            $result6 = $mysqli5->query($sql);
            $friend = $result6->fetch_assoc();

            if (!empty($friend)) {
                array_push($realFriends, $friend['usr1id']);
            }
        }

        // print_r($realFriends);
        if (sizeof($realFriends) == 0) {
            echo "No friends.";
        } else {
            for ($i = 0; $i < sizeof($realFriends); $i++) {
                $stmt5 = sprintf("SELECT *  FROM Pooper WHERE userid = " . $realFriends[$i]);
                $result5 = $mysqli5->query($stmt5);
                $users = $result5->fetch_assoc();

                echo $users['fName'];
            }
        }
    }
}
?>

<html>

<header Friends Page </header>

    <body>
        <br>
        <form id="friendform" method="post">
            <input type="email" name="email" placeholder="Search for an email:"><br><br>
            <input type="submit" value="Search" />
        </form>
    </body>

</html>