<?php
session_start();
include("connection.php");
include("functions.php");

if(isset($_GET['search-term']) && !empty(trim($_GET['search-term']))) {
    $search_term = trim($_GET['search-term']);
    $stmt = $con->prepare("SELECT userID FROM Users WHERE userFirstName LIKE ?");
    $search_term = "%".$search_term."%";
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Debugging output
        echo $_GET;
        echo "Redirecting to user profile: " . $row['userID'];
        // Actual redirection
        header("Location: view_profile.php?userID=" . $row['userID']);
        exit;
    } else {
        echo $_GET;
        echo "User not found. <a href='index.php'>Go back</a>";
    }
    $stmt->close();
} else {
    echo $_GET;
    echo "No search term specified. <a href='index.php'>Go back</a>";
}
?>