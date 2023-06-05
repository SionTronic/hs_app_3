<?php
$host = "localhost";
$user = "root";
$password = "Paragl2der";
$dbname = "cadarn";

$con = mysqli_connect($host, $user, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>