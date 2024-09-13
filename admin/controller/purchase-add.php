<?php
// เชื่อมต่อกับฐานข้อมูล (ใช้ include หรือ require เพื่อเชื่อมต่อกับฐานข้อมูล)
include('../../config/database.php');

// รับข้อมูลการขายจากหน้าฟอร์ม
$data = json_decode(file_get_contents("php://input"));

// ตรวจสอบและเตรียมข้อมูลสำหรับการบันทึก
$memberTel = $data->memberTel;
$salesDate = $data->salesDate;
$items = $data->items;

// ตรวจสอบรหัสลูกค้าจากตาราง member โดยใช้ $customerTel
$checkMemberSql = "SELECT * FROM member WHERE member_tel = ?";
$checkMemberStmt = $conn->prepare($checkMemberSql);
$checkMemberStmt->bind_param("s", $memberTel);
$checkMemberStmt->execute();
$checkMemberResult = $checkMemberStmt->get_result();

if ($checkMemberResult->num_rows > 0) {
    $MemberRow = $checkMemberResult->fetch_assoc();
    $MemberId = $MemberRow['member_id'];

    // บันทึกข้อมูลการขายลงในตาราง sales
    $sqlSales = "INSERT INTO sales (member_id, sales_date, total_quantity, total_price, total_points) VALUES (?, ?, ?, ?, ?)";
    $stmtSales = $conn->prepare($sqlSales);

    // กำหนดค่าข้อมูลการขาย
    $member_id = $MemberId;
    $sales_date = $salesDate;
    $total_quantity = 0;
    $total_price = 0;
    $total_points = 0;

    // คำนวณรวมยอดสินค้า
    foreach ($items as $item) {
        $total_quantity += $item->quantity;
        $total_price += $item->price * $item->quantity;
        $total_points += $item->points * $item->quantity;
    }

    $stmtSales->bind_param("issdd", $member_id, $sales_date, $total_quantity, $total_price, $total_points);
    $stmtSales->execute();

    // ดึงรหัสการขาย (sales_id) ที่สร้างขึ้นใหม่
    $salesId = $stmtSales->insert_id;

    // ปิดคำสั่ง SQL
    $stmtSales->close();

    // วนลูปเพื่อบันทึกรายละเอียดการขายลงในตาราง sales_details
    foreach ($items as $item) {
        $product_id = $item->product_id;
        $itemName = $item->itemName;
        $price = $item->price;
        $points = $item->points;
        $quantity = $item->quantity;

        // บันทึกรายละเอียดการขายลงในตาราง sales_details
        $sqlDetails = "INSERT INTO sales_details (sales_id, product_id, product_name, price, points, quantity) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtDetails = $conn->prepare($sqlDetails);
        $stmtDetails->bind_param("iisdii", $salesId, $product_id, $itemName, $price, $points, $quantity);
        $stmtDetails->execute();
        $stmtDetails->close();
    }

    // ...

    $totalPointsEarned = $total_points; // จำนวนแต้มที่ได้จากการขาย
    $currentPoints = $MemberRow['points']; // จำนวนแต้มปัจจุบันของลูกค้า
    $newPoints = $currentPoints + $totalPointsEarned; // จำนวนแต้มใหม่

    // อัปเดตจำนวนแต้มในตาราง member
    $updatePointsSql = "UPDATE member SET points = ? WHERE member_id = ?"; // แก้ customerId เป็น member_id
    $stmtUpdatePoints = $conn->prepare($updatePointsSql);
    $stmtUpdatePoints->bind_param("ii", $newPoints, $member_id); // แก้ customerId เป็น member_id
    $stmtUpdatePoints->execute();
    $stmtUpdatePoints->close();

    // ...


    // ส่งข้อความหลังจากบันทึกเสร็จสิ้น
    echo "บันทึกการขายเรียบร้อยแล้ว";
} else {
    // หากไม่พบรหัสลูกค้าในตาราง customer
    echo "ไม่พบรหัสลูกค้าที่ตรงกับเบอร์โทรที่ระบุ";
}
