<?php

session_start();

    require("connection.php");
    include("functions.php");

    $query = "SELECT * FROM Users WHERE userEmail = '$userEmail' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {

        $user_data = mysqli_fetch_assoc($result);

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
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#"><img src="./Assets/logo.svg"/></a>
        
    </nav>
</body>
</html>