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
    <div class = "container align-items-center" style="height: 100vh;">
        <div class = "row h-100">
            <div class="col-lg-4 col-md-2 my-auto"></div>
            <div class="col-lg-4 col-md-8 my-auto text-center">
                <img class = "mb-4" src="./Assets/logo.svg"/>
                <form method = "post" class = "text-center mx-5">
                    <h3>Create a new account</h3>

                    <label class = "sr-only" for="userFirstNameInput">First Name</label>
                    <input 
                    class = "form-control my-3 rounded-pill pl-3" 
                    id="userFirstNameInput" 
                    type="text" 
                    name="userFirstName"
                    placeholder="First name"
                    required/>

                    <label class = "sr-only" for="userLastNameInput">Last Name</label>
                    <input 
                    class = "form-control my-3 rounded-pill pl-3" 
                    id="userLastNameInput" 
                    type="text" 
                    name="userLastName"
                    placeholder="Last name"
                    required/>

                    <label class = "sr-only" for="userEmail">Email</label>
                    <input 
                    class = "form-control my-3 rounded-pill pl-3" 
                    id="userEmail" 
                    type="email" 
                    name="userEmail"
                    placeholder="Email Address"
                    required/>

                    <label class = "sr-only" for="userPassword">Password</label>
                    <input 
                    class = "form-control my-3 rounded-pill pl-3" 
                    id="userPassword" 
                    type="password" 
                    name="userPassword"
                    placeholder="Password"
                    required/>

                    <label class = "sr-only" for="userRepeatPassword">Repeat Password</label>
                    <input 
                    class = "form-control my-3 rounded-pill pl-3" 
                    id="userRepeatPassword" 
                    type="password" 
                    name="userRepeatPassword"
                    placeholder="Repeat Password"
                    required/>

                    <input class="primary-button btn-block mt-4 mb-3 py-3" id="button" type="submit" value="Signup">

                </form>
            </div>
            <div class="col-lg-4 col-md-2 my-auto"></div>
        </div>
    </div>
</body>
</html>