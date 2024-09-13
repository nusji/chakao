<?php
session_start();
include('../config/database.php');

// ตรวจสอบ Session และควบคุมการใช้งานปุ่ม Back
if (isset($_SESSION['member_tel'])) {
    // ผู้ใช้เข้าสู่ระบบแล้ว
    header('Location: views/dashboard.php'); // หรือไปยังหน้าที่คุณต้องการ
    exit();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_tel = $_POST["tel"];
    $password = $_POST["password"];

    // ตรวจสอบลูกค้า
    $stmt = $conn->prepare("SELECT member_tel, password, customer_id, member_id FROM member WHERE member_tel = ? AND password = ?");
    $stmt->bind_param("ss", $member_tel, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {        // ล็อกอินเป็นลูกค้า
        $memberInfo = $result->fetch_assoc(); // เก็บ session สำหรับลูกค้า
        $_SESSION['member_id'] =  $memberInfo['member_id'];
        $_SESSION['customer_id'] = $memberInfo['customer_id'];
        

        // ดึงข้อมูลจากตาราง "customer" โดยอ้างอิงจาก customer_id
        $customerStmt = $conn->prepare("SELECT first_name FROM customer WHERE customer_id = ?");
        $customerStmt->bind_param("i",  $memberInfo['customer_id']);
        $customerStmt->execute();
        $customerResult = $customerStmt->get_result();
        if ($customerResult->num_rows > 0) {
            $customerInfo = $customerResult->fetch_assoc();
            // เก็บข้อมูลจากตาราง "customer" ใน session
            $_SESSION['first_name'] = $customerInfo['first_name'];
        }

        // เพิ่มข้อมูลอื่น ๆ ที่คุณต้องการเก็บใน Session
        $_SESSION['member_tel'] = $member_tel;

        sleep(0.5);
        header('Location: views/dashboard.php'); // ให้ลูกค้าไปยังหน้า dashboard ของลูกค้า
        exit();
    } else {
        require('assets/pop/user-notfound.html');
    }

    $conn->close();
}
