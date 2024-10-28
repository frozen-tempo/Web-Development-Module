<link rel="stylesheet" href="CSS/navbar.css">

<nav class="navbar navbar-expand-lg brand-primary">
    <div class="d-flex justify-content-between w-100">
        <a href="index.php"><img class="nav-logo" src="./Assets/logo.svg"/></a>
        <form class = "d-flex w-50"action="search_profile.php" method="get">
            <input class = "form-control mr-sm-2 rounded w-100 align-self-center" name = "search-term" type="text" placeholder="Search..." aria-label="Search...">
            <input class="secondary-button align-self-center rounded-circle" type="submit" value = "Go">
        </form>
        <?php echo "<a href='view_profile.php?userID=" . urlencode($user_data['userID']) . "'><img class='nav-logo m-2' src='$user_data[profilePhoto]' /></a>";?>
    </div>
</nav>
