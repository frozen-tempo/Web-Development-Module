<?php 

session_start();

    include("connection.php");
    include("functions.php");

    $user_data = CheckLoginStatus($con);
    $user_friends = GetUserFriends($con);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/index.css">

</head>
<body>
    <div class="container-fluid">
        <div class="row mb-5" style="height: 32.5vh;">
            <div class="col px-0" id="avatar-header">
                <img src="./Assets/avatar-pink.png"/>
                <h3 id="profile-name"><?php echo $user_data['userFirstName'] . " " . $user_data['userLastName'];?></h3>
            </div>
        </div>
        <div id="friend-list">
            <?php 
            foreach ($user_friends as $friend) {
                echo $friend, '<br>';
            }
            ?>
        </div>
        <a href="logout.php">Logout</a>
    </div>
    <script src="index.js";></script>
</body>
</html>