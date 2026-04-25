<?php
$user = "bafaf";
$host = "localhost";
$password = "jpE1X^3Y%PfmZ0764#GB";
$db = "roster_db";

$conn = new mysqli($host, $user, $password, $db);
if($conn->connect_error){
  die("The conextion failed" . $conn->connect_error);
}
?>