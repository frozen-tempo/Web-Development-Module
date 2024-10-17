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

        // Check the email input is in the valid format
        $emailRegExPattern = "/^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8}(\.[a-z]{2,8})?$/";
        if (!preg_match($emailRegExPattern, $email)) {
            return [false,"Invalid email, please enter valid email to signup"];
        }

        // Check the email doesn't already exist in the database
        $query = "SELECT * FROM Users WHERE userEmail = '$email'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            return [false,"Email already exists, please login or try another email"];
        }

        return [true,""];

    }
    function CheckSignupPassword ($con, $password) {
        $lowercaseRegex = "/[a-z]/g";
        $capitalRegex = "/[A-Z]/g";
        $numberRegex = "/[0-9]/g";
        $specialRegex = "/[^A-Za-z0-9]/g";

        if (!preg_match($lowercaseRegex, $password) OR 
            !preg_match($capitalRegex, $password) OR
            !preg_match($numberRegex, $password) OR
            !preg_match($specialRegex, $password)) {
                return [false,"Invalid password, please check requirements"];
        }
        return [true,""];
    }

    function CheckAdminKey( $con, $adminKey ) {

        include_once("admin.php");

        if ($adminKey === "") {
            return [true,"", "basic"];
        }

        if ($adminKey !== $adminMasterKey) {
            return [false,"Invalid Admin Key", ""];
        }
        if ($adminKey === $adminMasterKey) {
            return [true,"", "admin"];
        }



    }

?>