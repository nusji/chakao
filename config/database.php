<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chakao";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("เกิดข้อผิดพลาด : " . $conn->connect_error);
}
?>