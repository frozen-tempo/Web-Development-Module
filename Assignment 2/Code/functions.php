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

    function GetUserInfo($con, $id) {
        $query = "SELECT * FROM Users WHERE userID = '$id' limit 1";
        $result = mysqli_query($con,$query);
        $data = mysqli_fetch_assoc($result);

        return $data;
    }

    function GetUserFriends($con) {
        if (isset($_SESSION["userID"])){

            $userID = $_SESSION["userID"];
            $query = "SELECT * FROM Friendships WHERE (friendshipStatus = 'accepted' AND initiator = '$userID') OR (friendshipStatus = 'accepted' AND responder = '$userID')";
            $friendships = [];
            $friend_list =[];

            $result = mysqli_query($con,$query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($friendships, $row);
                }
            }

            foreach ($friendships as $friend) {
                if ($friend['initiator'] != $userID) {
                    $friend_id = $friend['initiator'];
                    $friend_data = GetUserInfo($con, $friend_id);
                    if ($friend_data) {
                        $friend_name = $friend_data["userFirstName"] . " " . $friend_data["userLastName"];
                        $friend_photo = $friend_data["profilePhoto"];
                        array_push($friend_list, [$friend_name, $friend_photo, $friend_id]);
                    }
                }
                elseif ($friend['responder'] != $userID) {
                    $friend_id = $friend['responder'];
                    $friend_data = GetUserInfo($con, $friend_id);
                    if ($friend_data) {
                        $friend_name = $friend_data["userFirstName"] . " " . $friend_data["userLastName"];
                        $friend_photo = $friend_data["profilePhoto"];
                        array_push($friend_list, [$friend_name, $friend_photo, $friend_id]);
                    }
                }
            }
            return $friend_list;
        }
    }

    function GetProfilePosts($con) {
        if (isset($_SESSION["userID"])){

            $userID = $_SESSION["userID"];
            $post_list = [];
            $query = "SELECT * FROM Posts WHERE userID = '$userID' ORDER BY postCreationDate DESC";
            $result = mysqli_query($con,$query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($post_list, $row);
                }
            }
        return $post_list;
        }
    }

    function GetPostComments($con, $post) {

        $postID = $post['postID'];
        $comment_list = [];
        $query = "SELECT * FROM Comments WHERE postID = '$postID' ORDER BY commentCreationDate ASC";
        $result = mysqli_query($con,$query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($comment_list, $row);
            }
        }
        return $comment_list;
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