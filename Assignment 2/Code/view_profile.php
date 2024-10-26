<?php

session_start();

require("connection.php");
include("functions.php");

if (isset($_GET["userID"])) {
    $userID = $_GET["userID"];
    $query = "SELECT * FROM Users WHERE userID = ? LIMIT 1";
    $statement = $con->prepare($query);
    $statement->bind_param("s", $userID);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h1>". $row["userFirstName"] ."</h1>";
    }
    else {
        echo "User not found";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>