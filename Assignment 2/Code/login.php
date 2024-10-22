<?php
session_start();

    require("connection.php");
    include("functions.php");
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $userEmail = $_POST["userEmail"];
        $userPassword = $_POST["userPassword"];
        $loginError = "";
        $showUserWelcome = false;

        if (!empty($userEmail) && !empty($userPassword)) {

            $query = "SELECT * FROM Users WHERE userEmail = '$userEmail' LIMIT 1";
            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {

                $user_data = mysqli_fetch_assoc($result);

                if (password_verify($_POST["userPassword"], $user_data["userPassword"])) {
                    $_SESSION['userID'] = $user_data['userID'];
                    $showUserWelcome = true;
                    header("refresh:5;url=index.php");
                }
                else {
                    $loginError = "Incorrect Login Information, Please Try Again.";
                }
            }
        }
        else {
            $loginError = "Please fill out the required fields for login.";
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
            <div class="col-lg-3 col-md-2 my-auto"></div>
            <div class="col-lg-6 col-md-8 my-auto text-center fade-in">
                <?php if ($showUserWelcome):?>
                    <img id = "welcome-image" src = "./Assets/welcome.svg"/>
                    <h3>Hey <?php echo $user_data['userFirstName'];?></h3>
                    <p>Let's get you back to your profile!</p>
                <?php else:?>
                <img class = "mb-4" src="./Assets/logo.svg"/>
                <div class = "hidden" id = "login-error">
                    <?php
                        echo "<p>$loginError</p>";
                    ?>
                </div>
                <form id = "login-form" method = "post" class = "text-center">
                    <label class = "sr-only" for="userEmailInput">Email Address</label>
                        <input 
                        class = "form-control my-3 rounded-pill pl-3" 
                        id="userEmailInput" 
                        type="email" 
                        name="userEmail"
                        placeholder="Email Address"
                        required/>
                    
                    <label class = "sr-only" for="userPasswordInput">Password</label>
                        <input 
                        class = "form-control mb-3 rounded-pill pl-3" 
                        id="userPasswordInput" 
                        type="password" 
                        name="userPassword"
                        placeholder="Password"
                        required/>
                    <input class="primary-button btn-block mt-4 mb-3 py-3" id="button" type="submit" value="Login">
                    <a class = "link-primary mb-2" href="password_recovery.php">Forgotten your password?</a>
                    <hr>
                    <a class="secondary-button btn-block mt-4 py-3" href = "signup.php">Create Account</a>
                </form>
                <?php endif;?>
            </div>
            <div class="col-lg-3 col-md-2 my-auto"></div>
        </div>
    </div>
    <script>
        var loginError = <?php echo ($loginError != null) ? json_encode($loginError) : ""; ?>;
    </script>
    <script src="login.js";></script>
</body>
</html>