<?php

    function CheckLoginStatus($con) {

        if (isset($_SESSION["userID"])){

            $userID = $_SESSION["userID"];
            $query = "SELECT * FROM Users WHERE userID = '$userID' limit 1";

            $result = mysqli_query($con,$query);
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                return $user_data;
            }
        }
        //Redirect User to Login Page
        header("Location: login.php");
        die;
    }

    function GetUserPosts($con) {
        if (isset($_SESSION["userID"])){

            $userID = $_SESSION["userID"];
        }
    }

    function CheckSignupInformation ($con) {
        return;
    }
?>