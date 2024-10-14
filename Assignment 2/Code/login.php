<?php
session_start();

    require("connection.php");
    include("functions.php");
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $userEmail = $_POST["userEmail"];
        $userPassword = $_POST["userPassword"];

        if (!empty($userEmail) && !empty($userPassword)) {

            $query = "SELECT * FROM Users WHERE userEmail = '$userEmail' LIMIT 1";
            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {

                $user_data = mysqli_fetch_assoc($result);

                if ($user_data["userPassword"] === $userPassword) {
                    $_SESSION['userID'] = $user_data['userID'];
                    header("Location: index.php");
                    die;
                }
            }
            echo "Incorrect Login Information, Please Try Again.";
        }
    else {
        echo "Incorrect Login Information, Please Try Again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/login.css">
<body>
    <div class = "container">
        <div class = "row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8">
                <img/>
                <form method = "post" class = "text-center mx-5">
                    <label class = "sr-only" for="userEmailInput">Email Address</label>
                        <input 
                        class = "form-control mb-3" 
                        id="userEmailInput" 
                        type="email" 
                        name="userEmail"
                        placeholder="Email Address"
                        required/>
                    
                    <label class = "sr-only" for="userPasswordInput">Email Address</label>
                        <input 
                        class = "form-control mb-3" 
                        id="userPasswordInput" 
                        type="password" 
                        name="userPassword"
                        placeholder="Password"
                        required/>
                    <input class="btn primary-button btn-block mb-3" id="button" type="submit" value="Login">

                </form>
            </div>
            <div class="col-lg-3 col-md-2"></div>
        </div>
    </div>
</body>
</html>