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

    function GetUserFriends($con) {
        if (isset($_SESSION["userID"])){

            $userID = $_SESSION["userID"];
            $query = "SELECT * FROM Friendships WHERE (friendshipStatus = 'accepted' AND initiator = '$userID') OR (friendshipStatus = 'accepted' AND responder = '$userID')";
            $friendships = [];
            $friend_list =[];

            $result = mysqli_query($con,$query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                foreach ($result as $friendship) {
                    array_push($friendships, $friendship);
                }
            }

            foreach ($friendships as $friend) {
                if ($friend['initiator'] != $userID) {
                    $friend_id = $friend['initiator'];
                    $friend_query = "SELECT * FROM Users WHERE userID = '$friend_id' limit 1";
                    $friend_result = mysqli_query($con,$friend_query);
                    if ($friend_result && mysqli_num_rows($friend_result) > 0) {
                        $friend_data = mysqli_fetch_assoc($friend_result);
                        $friend_name = $friend_data["userFirstName"] . " " . $friend_data["userLastName"];
                        array_push($friend_list, $friend_name);
                    }
                }
                elseif ($friend['responder'] != $userID) {
                    $friend_id = $friend['responder'];
                    $friend_query = "SELECT * FROM Users WHERE userID = '$friend_id' limit 1";
                    $friend_result = mysqli_query($con,$friend_query);
                    if ($friend_result && mysqli_num_rows($friend_result) > 0) {
                        $friend_data = mysqli_fetch_assoc($friend_result);
                        $friend_name = $friend_data["userFirstName"] . " " . $friend_data["userLastName"];
                        array_push($friend_list, $friend_name);
                    }
                }
            }
            return $friend_list;
        }
    }


    function GetUserPosts($con) {
        if (isset($_SESSION["userID"])){

            $userID = $_SESSION["userID"];
        }
    }

    function CheckSignupNames ($firstName, $lastName) {
        if (!empty($firstName) && !empty($lastName) && !is_numeric($firstName) && !is_numeric($lastName)) {
        return [true, ""];
        }
        else {
            return [false, "Valid first and last names must be entered to sign up"];
        }
    }

    function CheckSignupEmail ($con, $email) {

        // Check the email input is in the valid format
        $emailRegExPattern = "/^(?!.*[.]{2})([A-Za-z0-9._-])+@([A-Za-z])+.([A-Za-z]){2,8}$/";
        if (!preg_match($emailRegExPattern, $email)) {
            return [false,"Invalid email, please enter valid email to signup"];
        }

        // Check the email doesn't already exist in the database
        $query = "SELECT * FROM Users WHERE userEmail = '$email'";
        $result = mysqli_query($con, $query);

        // If a result is returned from the query then an entry exists and therefore the email entered is a duplicate
        if (mysqli_num_rows($result) > 0) {
            return [false,"Email already exists, please login or try another email"];
        }

        return [true,""];

    }

    function CheckSignupPassword ($password, $repeatPassword) {
        $lowercaseRegex = "/[a-z]/";
        $capitalRegex = "/[A-Z]/";
        $numberRegex = "/[0-9]/";
        $specialRegex = "/[^A-Za-z0-9]/";

        if (!preg_match($lowercaseRegex, $password) OR 
            !preg_match($capitalRegex, $password) OR
            !preg_match($numberRegex, $password) OR
            !preg_match($specialRegex, $password)) {
                return [false,"Invalid password, please check requirements"];
        }
        if ($password !== $repeatPassword) {
            return [false,"The passwords you have entered do not match, please try again"];
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

    function CreateNewUser($con, $id, $accessLevel, $firstName, $lastName, $email, $password) {
        $sqlQuery = $con->prepare("INSERT INTO Users (userID, userLevel, userFirstName, userLastName, userEmail, userPassword) VALUES (?, ?, ?, ?, ?, ?)");
        if ($sqlQuery === false) {
            echo "<br>" . "error preparing" . "<br>";
        }

        if (!$sqlQuery->bind_param("ssssss", $id, $accessLevel, $firstName, $lastName, $email, $password)) {
            echo "<br>" . "error binding" . "<br>";
        }

        $querySuccessful = true;

        if (!$sqlQuery->execute()) {
            $querySuccessful = false;   
        }
            return $querySuccessful;
    }

?>