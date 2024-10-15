<?php 

session_start();

    include("connection.php");
    include("functions.php");

    $user_data = CheckLoginStatus($con)

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script>

        


    </script>

</head>
<body>
    <h1>Welcome to index page</h1>
    <p>Hello <?php echo $user_data['userID'];?>, we've been expecting you.</p>
    <a href="logout.php">Logout</a>
</body>
</html>