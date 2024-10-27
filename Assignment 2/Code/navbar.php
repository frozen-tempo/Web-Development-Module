<link rel="stylesheet" href="CSS/navbar.css">

<nav class="navbar navbar-expand-lg brand-primary">
    <div class="d-flex justify-content-between w-100">
        <a href="index.php"><img class="nav-logo" src="./Assets/logo.svg"/></a>
        <input class = "form-control mr-sm-2 rounded w-50 align-self-center" type="search" placeholder="Search..." aria-label="Search...">
        <?php echo "<a href='view_profile.php?userID=" . urlencode($user_data['userID']) . "'><img class='nav-logo m-2' src='$user_data[profilePhoto]' /></a>";?>
    </div>
</nav>
