<?php
// เปลี่ยนเส้นทางไปยัง "src/login.php" ทันทีที่หน้าเว็บโหลด
header('Location: src/login.php');
exit(); // ควรใช้ exit() หลังจาก header() เพื่อหยุดการประมวลผลสคริปต์เพิ่มเติม
?>
