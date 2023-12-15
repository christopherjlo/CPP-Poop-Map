<?php
session_start();

$tableHtml = "<table class='friends-table border'cellspacing=\"0\" cellpadding=\"0\">
<tr>
    <th>Name</th>
</tr>";
$responseMsg = "";

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
        $responseMsg = "No Friends :(";
    } else {
        for ($i = 0; $i < sizeof($realFriends); $i++) {
            $stmt5 = sprintf("SELECT *  FROM Pooper WHERE userid = " . $realFriends[$i]);
            $result5 = $mysqli5->query($stmt5);
            $users = $result5->fetch_assoc();

            $tableHtml .= "<tr class='border'>";
            $tableHtml .= "<td class='border'>". $users["fName"] . ' ' . $users["lName"] . "</td>";
            $tableHtml .= "</tr>";
        }
    }
} else {echo("session not set!");}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database/database.php";

    $sql = sprintf("SELECT * FROM Pooper WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if (empty($user)) {
        $responseMsg = 'User not found!';
    } else {
        $currentID = $_SESSION["currentID"]; // change later
        $searchedID = $user['userid'];

        if ($currentID == $searchedID) {
            $responseMsg = "Unforunately, you can't friend yourself :(";
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
                $responseMsg = 'You are already friended with this person,';
            } else {
                $sql4 = sprintf("INSERT INTO Friends (usr1id, usr2id) values(" . $currentID . ", " . $searchedID . ')');
                $mysqli->query($sql4);
                $responseMsg = 'You have friended this person';
            }

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
                $responseMsg .= ' and they have you friended as well!';
            } else {
                $responseMsg .= ' but they have not friended you yet!';
            }

            // if ($currentFriendedToSearched == True && $searchedFriendedtoCurrent == True) {
            //     echo '     TRUE FRIENDS FOUND';
            // }
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

                //echo $users['fName'];
            }
        }
    }
}
?>

<html>

    <head>
        <title>Friends Page</title>
        <link rel="stylesheet" href="styles/friends.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    </head>

    <body>
        <div id="bg_div">
            <br>
            <h2 style='text-align: center;'>Friends List</h2>
            <div class = "search-friend">
                <form id="friendform" method="post">
                    <input type="email" name="email" placeholder="Search for an email:"><br><br>
                    <i ></i>
                    <input type="submit" value="Add Friend" />
                </form>
            </div>
            <div class = 'header'>

            </div>
            <div class = 'table-container'>
                <div style = 'font-weight: bold; margin-left: auto; margin-right: auto;'><?php echo $responseMsg ?></div>
                <div class = 'table-child'>
                    <?php echo $tableHtml; ?>
                </div>
            </div>
        </div>
    </body>

</html>