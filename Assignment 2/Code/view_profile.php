<?php

session_start();

require("connection.php");
include("functions.php");

$user_data = CheckLoginStatus($con);

if (isset($_GET["userID"])) {
    $userID = $_GET["userID"];
    $query = "SELECT * FROM Users WHERE userID = ? LIMIT 1";
    $statement = $con->prepare($query);
    $statement->bind_param("s", $userID);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows > 0) {
        $profile_data = $result->fetch_assoc();
    }
}
    $user_friends = GetUserFriends($con, $userID);
    $profile_posts = GetProfilePosts($con, $userID);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/view_profile.css">
</head>
<body>
    <?php include "navbar.php";?>
    <div class="container-fluid">
        <div class="row mb-5" style="height: 32.5vh;">
            <div class="col px-0" id="avatar-header">
                <img src="<?php echo $profile_data['profilePhoto']?>"/>
                <h4 class="w-100 text-center profile-name"><?php echo $profile_data['userFirstName'] . " " . $profile_data['userLastName'];?></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-2 my-auto"></div>
            <div class="col-lg-6 col-md-8 my-auto">
                <h4>Friend List</h4>
                <div class="d-flex flex-wrap justify-content-start">
                <?php 
                foreach ($user_friends as $friend) {
                    echo "<a href='view_profile.php?userID=" . urlencode($friend[2]) . "'><img class='friend-avatar m-2' src='$friend[1]' /></a>";
                }
                ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-2 my-auto"></div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-2 my-auto"></div>
            <div class="col-lg-6 col-md-8 my-auto">
                <div class="d-flex justify-content-between">
                    <h4>Posts</h4>
                    <button>Create New Post</button>
                </div>
                <div class="d-flex flex-column">
                    <?php 
                    foreach ($profile_posts as $post) {
                        $post_comments = GetPostComments($con, $post);
                        $comments = "";
                        foreach ($post_comments as $comment) {
                            $commenter_data = GetUserInfo($con, $comment['userID']);
                            $comments .=
                            "<div class='d-flex my-2 rounded'>
                                <div class=''>
                                    <img class='post-avatar'src='$commenter_data[profilePhoto]'/>
                                </div>
                                <div class = 'w-100 p-2 rounded bg-light'>
                                    <h6 class='post-name'>$commenter_data[userFirstName] $commenter_data[userLastName]</h6>
                                    <p class ='post-content text-justify'>$comment[commentText]</p>
                                </div>
                            </div>";
                            }
                        echo 
                        "<div class='p-2 rounded shadow-sm d-flex my-3'>
                            <div class=''>
                                <img class='post-avatar'src='$profile_data[profilePhoto]'/>
                            </div>
                            <div class='d-flex flex-column w-100'>
                                <div class = 'w-100 px-2'>
                                    <h6 class='post-name'>$profile_data[userFirstName] $profile_data[userLastName]</h6>
                                    <small><i>$post[postCreationDate]</i></small>
                                    <p class ='post-content text-justify'>$post[postText]</p>
                                    <hr>
                                </div>
                                <div class='d-flex justify-content-end m-1'>
                                    <button class='mx-2'>Like</button>
                                    <button class='mx-2'>Comment</button>
                                </div>
                                <hr>
                                $comments
                            </div>
                            <hr>
                        </div>";
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-2 my-auto"></div>
        </div>
        <a href="logout.php">Logout</a>
    </div>
    
</body>
</html>