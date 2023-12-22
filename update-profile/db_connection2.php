<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "id21705587_loginotakuoracle"; 

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
