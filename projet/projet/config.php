<?php
$servername = "localhost";
$username = "root";
$password = "";
$myDB = "projet_pfa";

$conn = mysqli_connect($servername, $username, $password, $myDB);
mysqli_set_charset($conn, "utf8mb4");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>