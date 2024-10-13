<?php 

$dbhost = "lochnagar.abertay.ac.uk";
$dbuser = "sql2307369";
$dbpass = "manual-struck-lane-hero";
$dbname = "sql2307369";

if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die("Failed to connect!");
}   else {
    echo "Connected" , "<br>";
}