<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qcumerchmart_db";

$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>