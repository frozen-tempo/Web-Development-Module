<?php

    // Checks if the user is sucessfully logged in
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

    // Retrieves data for any user given a user ID
    function GetUserInfo($con, $id) {
        $query = "SELECT * FROM Users WHERE userID = '$id' limit 1";
        $result = mysqli_query($con,$query);
        $data = mysqli_fetch_assoc($result);

        return $data;
    }

    // Gets a list of friends for any user given a user ID
    function GetUserFriends($con, $id) {
        // Makes sure a valid user is logged in
        if (isset($_SESSION["userID"])){

            $userID = $id;
            // Filters the friendship table for friendships only involving the given user
            $query = "SELECT * FROM Friendships WHERE (friendshipStatus = 'accepted' AND initiator = '$userID') OR (friendshipStatus = 'accepted' AND responder = '$userID')";
            $friendships = [];
            $friend_list =[];

            $result = mysqli_query($con,$query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($friendships, $row);
                }
            }

            // Loop through each friendship and get the information for the user which is not the given user
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
        }
        return $friend_list;
    }

    // Gets posts for the main feed only, this only includes posts from friends and not personal posts
    function GetFeedPosts($con, $id) {
        if (isset($_SESSION["userID"])){

            $userID = $id; // logged in user id
            // Get the friend list of the given user
            $friends = GetUserFriends($con, $userID);
            $post_list = [];
            // Loop through all friends and filter the Posts table where they are the post creator
            foreach ($friends as $friend) {
                $query = "SELECT * FROM Posts WHERE userID = '$friend[2]' ORDER BY postCreationDate DESC";
                $result = mysqli_query($con,$query);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        array_push($post_list, $row);
                    }
                }
            }
        return $post_list;
        }
    }

    // Gets posts for the profile feed only, this only includes posts from the profile page owner

    function GetProfilePosts($con, $id) {
        if (isset($_SESSION["userID"])){

            $userID = $id; // profile owner id
            $post_list = [];
            // Filters Posts table where the profile owner is the post creator
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

    // Gets all comments for a given post
    function GetPostComments($con, $post) {

        $postID = $post['postID'];
        $comment_list = [];
        // Filters the comments table where the post ID matches the given post
        $query = "SELECT * FROM Comments WHERE postID = '$postID' ORDER BY commentCreationDate ASC";
        $result = mysqli_query($con,$query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($comment_list, $row);
            }
        }
        return $comment_list;
    }

    // Handles the creation of comments and insertion into the database table
    function HandleCreateComment($con, $user_id, $post_id, $post_comment) {

        $userID = $user_id; // comment author
        $postID = $post_id; // post which the comment is on
        $postComment = $post_comment; // content of the comment
        $sqlQuery = $con->prepare("INSERT INTO Comments (userID, postID, commentText) VALUES (?, ?, ?)");
        if ($sqlQuery === false) {
            echo "<br>" . "error preparing" . "<br>";
        }

        if (!$sqlQuery->bind_param("sss", $userID, $postID, $postComment)) {
            echo "<br>" . "error binding" . "<br>";
        }

        $querySuccessful = true;

        if (!$sqlQuery->execute()) {
            $querySuccessful = false;
        }
            return $querySuccessful;

    }

    // Handles the creation of posts and insertion into the database table
    function HandleCreatePost($con, $user_id, $post_text, $post_photo) {

        $userID = $user_id; // post creator id
        $postText = $post_text; // post content
        $postPhoto = $post_photo; // associated post image
        $target_dir = "Uploads/";
        $target_file = $target_dir . basename($_FILES["post-photo"]["name"]);
        $uploadOK = 1;
        // gets the file type from the uploaded file
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['post-photo']['tmp_name']);

        if ($check !== false) {
            $uploadOK = 1;
        }
        // checks if file is an image or not
        else {
            echo "File is not an image.";
            $uploadOK = 0;
        }
        // checks if the file size is too large to upload
        if ($_FILES['post-photo']['size'] > 5000000) {
            echo "Sorry, file too large";
            $uploadOK = 0;
        }
        // checks image file type is valid
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, file type of uploaded image is invalid";
            $uploadOK = 0;
        }

        if ($uploadOK == 1) {
            if ($_FILES['post-photo']['error'] == 0) {
                if (move_uploaded_file($_FILES['post-photo']['tmp_name'], $target_file)) {
                    echo "The file ". htmlspecialchars(basename($_FILES["post-photo"]["name"])) ." has now been uploaded.";
                    $postPhoto = $target_file;

                    $sqlQuery = $con ->prepare("INSERT INTO Posts (userID, postText, postPhoto) VALUES (?, ?, ?)");
                    if ($sqlQuery === false) {
                        echo "<br>" . "error preparing" . "<br>";
                    }
            
                    if (!$sqlQuery->bind_param("sss", $userID, $postText, $postPhoto)) {
                        echo "<br>" . "error binding" . "<br>";
                    }

                    $querySuccessful = true;

                    if (!$sqlQuery->execute()) {
                        $querySuccessful = false;
                    }
                    return $querySuccessful;
                }
                else {
                    if (!is_writable($target_dir)) {
                        echo "Target directory not writable";
                    }
                    if (!is_dir($target_dir)) {
                        echo "Target directory not exist";
                    }
                }
            }
            else {
                echo "File did not pass checks!";
            }

        }

    }

    // Handle the deletion of posts from the database table
    function DeletePost($con, $postID) {
        // Delete all comments associated with the post
        $sqlQueryComments = $con->prepare("DELETE FROM Comments WHERE postID = ?");
        if ($sqlQueryComments === false) {
            return false;
        }
        
        $sqlQueryComments->bind_param("i", $postID);
        $commentQuerySuccessful = $sqlQueryComments->execute();
        $sqlQueryComments->close();
        
        // Then delete the post itself
        $sqlQueryPost = $con->prepare("DELETE FROM Posts WHERE postID = ?");
        if ($sqlQueryPost === false) {
            return false;
        }
        
        $sqlQueryPost->bind_param("i", $postID);
        $postQuerySuccessful = $sqlQueryPost->execute();
        $sqlQueryPost->close();
        
        return $commentQuerySuccessful && $postQuerySuccessful;
    }
    
    // Deletes a specific comment base on comment ID
    function DeleteComment($con, $commentID) {
        $sqlQueryComments = $con->prepare("DELETE FROM Comments WHERE commentID = '$commentID'");
        if ($sqlQueryComments === false) {
            echo "<br>" . "error preparing" . "<br>";
        }
        $commentQuerySuccessful = true;

        if (!$sqlQueryComments->execute()) {
            $commentQuerySuccessful = false;
        }

        return $commentQuerySuccessful;
    
    }

    // Handles adding and removing likes from the database
    function HandlePostLike($con, $userID, $postID) {

        // Checks if post is already liked by the user
        $query = "SELECT * FROM Likes WHERE postID = '$postID' AND userID = '$userID'";
        $result = mysqli_query($con,$query);
        
        if ($result->num_rows > 0) {
            // If already liked then button is clicken then delete from database table
            $sqlQuery = $con->prepare("DELETE FROM Likes WHERE postID = '$postID' AND userID = '$userID'");
            if ($sqlQuery === false) {
                echo "<br>" . "error preparing" . "<br>";
            }
            $querySuccessful = true;
    
            if (!$sqlQuery->execute()) {
                $querySuccessful = false;
            }
                return $querySuccessful;

        } else {
            // Else add to database table

            $sqlQuery = $con->prepare("INSERT INTO Likes (postID, userID) VALUES (?,?)");
            if ($sqlQuery === false) {
                echo "<br>" . "error preparing" . "<br>";
            }
    
            if (!$sqlQuery->bind_param("ss", $postID, $userID)) {
                echo "<br>" . "error binding" . "<br>";
            }
            $querySuccessful = true;
    
            if (!$sqlQuery->execute()) {
                $querySuccessful = false;
            }
                return $querySuccessful;
        }
    }

    // Checks if post is already liked, returns true or false
    function IsPostLiked($con, $userID, $postID) {
        $sqlQuery = "SELECT * FROM Likes WHERE postID = '$postID' AND userID = '$userID'";
        $stmt = $con->prepare($sqlQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }


    
    // Checking signup names are valid
    function CheckSignupNames ($firstName, $lastName) {
        if (!empty($firstName) && !empty($lastName) && !is_numeric($firstName) && !is_numeric($lastName)) {
        return [true, ""];
        }
        else {
            return [false, "Valid first and last names must be entered to sign up"];
        }
    }
    // Additional stricter regex check for email as input field still allows some invalid inputs
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

    // Check if password meets security requirements
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

    // Checks for valid admin key to assign admin status on signup
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
    
    // Handles creating new users through the signup page
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