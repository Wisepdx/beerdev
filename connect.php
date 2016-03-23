<?php
//Test Server
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "beer";

//Live Server
// $servername="10.0.1.114";
// $username="beer";
// $password="wisepdx";
// $dbname="beer";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
