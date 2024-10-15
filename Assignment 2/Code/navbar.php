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
    <nav>
        <div class="nav-left">
            <img src = "./Assets/logo.svg"/>
            <label class ="sr-only">Profile Search Bar</label>
            <div class="search-bar">
                <input 
                    class="search-input" 
                    type="text" 
                    name="userProfileSearch" 
                    placeholder="Search for an existing user's profile"
                >
                <img class="search-icon"/>
            </div>
        </div>
        <ul class="nav-middle">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <div class="nav-right">
            <img src=""/>
            <p><?php echo $user_data["userFirstName"]; ?></p>
        </div>
    </nav>
</body>
</html>