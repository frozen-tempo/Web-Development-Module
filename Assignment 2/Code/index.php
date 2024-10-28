<?php 

session_start();

    require("connection.php");
    include("functions.php");

    $user_data = CheckLoginStatus($con);
    $user_friends = GetUserFriends($con, $_SESSION['userID']);
    $feed_posts = GetFeedPosts($con, $_SESSION['userID']);
    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handling of comment posting
        if (isset($_POST["comment-post-id"]) && isset($_POST["comment-text"])) {
            HandleCreateComment($con, $_SESSION['userID'], $_POST['comment-post-id'],$_POST['comment-text']);
        }
        //Handling of post deletion
        if (isset($_POST['delete-post'])&& isset($_POST['post_id'])) {
            DeletePost($con, $_POST['post_id']);
        }
        // Handling of comment deletion
        if (isset($_POST['delete-comment']) && isset($_POST['comment_id'])) {
            DeleteComment($con, $_POST['comment_id']);
        }
        //Handle of post liking and unliking
        if (isset($_POST['like'])) {
            HandlePostLike($con,$_SESSION['userID'], $_POST['post_id']);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Crowd</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/index.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>

</head>
<body>
    <?php include "navbar.php";?>
    <?php include "post_modal.php";?>
    <?php include "comment_modal.php";?>
    <div class="container-fluid">
        <div class="row mb-5" style="height: 32.5vh;">
            <div class="col px-0" id="avatar-header">
                <img src="<?php echo $user_data['profilePhoto']?>"/>
                <h4 class="w-100 text-center profile-name"><?php echo $user_data['userFirstName'] . " " . $user_data['userLastName'];?></h4>
                <a href="logout.php">Logout</a>
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
                    <button 
                    type = 'button' 
                    class='mx-2 btn brand-primary rounded' 
                    data-toggle='modal' 
                    data-target='#postModal'>
                    Create New Post
                    </button>
                </div>
                <div class="d-flex flex-column">
                    <?php 
                    foreach ($feed_posts as $post) {
                        $post_comments = GetPostComments($con, $post);
                        $post_user_data = GetUserInfo($con, $post['userID']);
                        $like_state = IsPostLiked($con, $_SESSION['userID'],$post['postID']) ? "liked" : "like";
                        $like_class = IsPostLiked($con, $_SESSION['userID'],$post['postID']) ? "btn liked" : "btn not-liked";
                        $delete_post_icon = $_SESSION["userLevel"] == "admin" ? 
                        "<form method='post'>
                            <input class='sr-only' name='post_id' value='$post[postID]' type='hidden'>
                            <button name='delete-post' type = 'submit''><img class='delete-icon'src='./Assets/delete.svg'/></button>
                        </form>" : "<p></p>" ;
                        if (strlen($post["postPhoto"]) !== 0) {
                            $post_img = "<img class='post-photo' src='$post[postPhoto]'/>";
                        }
                        else {
                            $post_img = "<div class='sr-only'></div>";
                        }

                        $comments = "";
                        foreach ($post_comments as $comment) {
                            $commenter_data = GetUserInfo($con, $comment['userID']);
                            $delete_comment_icon = $_SESSION["userLevel"] == "admin" ? 
                            "<form method='post'>
                                <input class='sr-only' name='comment_id' value='$comment[commentID]' type='hidden'>
                                <button name='delete-comment' type = 'submit''><img class='delete-icon'src='./Assets/delete.svg'/></button>
                            </form>" : "<p></p>" ;
                            $comments .=
                            "<div class='d-flex my-2 rounded'>
                                <div class='d-flex flex-column align-items-center'>
                                    <img class='post-avatar'src='$commenter_data[profilePhoto]'/>
                                    $delete_comment_icon
                                </div>
                                <div class = 'w-100 p-2 rounded bg-light'>
                                    <h6 class='post-name'>$commenter_data[userFirstName] $commenter_data[userLastName]</h6>
                                    <p class ='post-content text-justify'>$comment[commentText]</p>
                                </div>
                            </div>";
                            }
                        echo 
                        "<div class='p-2 rounded shadow-sm d-flex my-3'>
                            <div class='d-flex flex-column align-items-center'>
                                <img class='post-avatar'src='$post_user_data[profilePhoto]'/>
                                $delete_post_icon
                            </div>
                            <div class='d-flex flex-column w-100'>
                                <div class = 'w-100 px-2'>
                                    <h6 class='post-name'>$post_user_data[userFirstName] $post_user_data[userLastName]</h6>
                                    <small><i>$post[postCreationDate]</i></small>
                                    <p class ='post-content text-justify'>$post[postText]</p>
                                    $post_img
                                    <hr>
                                </div>
                                <div class='d-flex justify-content-end m-1'>
                                    <form method = 'post'>
                                        <input class='sr-only' name='post_id' value='$post[postID]' type='hidden'>
                                        <button name='like' type = 'submit' class='$like_class' '>$like_state</button>
                                    </form>
                                    <button 
                                    type = 'button' 
                                    class='mx-2 btn brand-primary rounded' 
                                    data-toggle='modal' 
                                    data-target='#commentModal' 
                                    data-post_id='$post[postID]'>
                                        Comment
                                    </button>
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
    </div>
    <script src="index.js";></script>
</body>
</html>