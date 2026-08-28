<?php

$host = "localhost";
$username = "root";
$password = "Aniket@2002";
$database = "college";

$conn = mysqli_connect(
    $host,
    $username,
    $password,
    $database
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Database connected successfully";

?>