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

    function CheckSignupNames ($con, $firstName, $lastName) {
        if (!empty($firstName) && !empty($lastName) && !is_numeric($firstName) && !is_numeric($lastName)) {
        return [true, ""];
        }
        else {
            return [false, "Valid first and last names must be entered to sign up"];
        }
    }


    function CheckSignupEmail ($con, $email) {
        $emailRegExPattern = "/^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8}(\.[a-z]{2,8})?$/";

        if (!preg_match($emailRegExPattern, $email)) {
            return [false,"Invalid email, please enter valid email to signup"];
        }
        else {
            return [true,""];
        }
    }
    function CheckSignupPassword ($con, $password) {


    }

?>