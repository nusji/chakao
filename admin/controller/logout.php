<?php
session_start();

// ยกเลิก Session และลบข้อมูล Session
session_unset();
session_destroy();
sleep(1); //delay เพิ่มความน่าเชื่อถือ
// ส่งกลับไปยังหน้าล็อกอินหรือหน้าหลัก
header('Location: ../admin-login.php'); // หรือไปยังหน้าที่คุณต้องการหลังจากล้อคเอาท์
exit();
?>
