<?php
session_start();
if (!isset($_SESSION['member_tel'])) {
    header("Location: ../login.php"); // ถ้ายังไม่ล็อกอิน ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอิน
    exit();
}
?>
