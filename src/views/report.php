<?php
// รวมไฟล์เช็คสถานะเซสชัน (session-status.php)
include('../controller/session-status.php');

// สร้างการเชื่อมต่อกับฐานข้อมูล (เปลี่ยนรายละเอียดตามเครื่องแม่ของคุณ)
include('../../config/database.php');

// ตรวจสอบ session member_id
if (isset($_SESSION['member_id'])) {
    $member_id = $_SESSION['member_id'];

    // คำสั่ง SQL เพื่อหาจำนวนครั้งและค่าใช้จ่ายการซื้อต่อสัปดาห์
    $sqlWeekly = "SELECT COUNT(*) AS weekly_count, SUM(total_price) AS weekly_total 
        FROM sales 
        WHERE member_id = $member_id AND sales_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)";

    // คำสั่ง SQL เพื่อหาจำนวนครั้งและค่าใช้จ่ายการซื้อต่อเดือน
    $sqlMonthly = "SELECT COUNT(*) AS monthly_count, SUM(total_price) AS monthly_total 
        FROM sales 
        WHERE member_id = $member_id AND sales_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)";

    // คำสั่ง SQL เพื่อหาสินค้าที่ถูกซื้อบ่อยที่สุด
    $sqlBestSellingProducts = "SELECT sd.product_name, SUM(sd.quantity) AS total_quantity
    FROM sales_details sd
    INNER JOIN sales s ON s.sales_id = sd.sales_id
    WHERE s.member_id = $member_id
    GROUP BY sd.product_name
    ORDER BY total_quantity DESC
    LIMIT 10";



    // คำสั่ง SQL เพื่อหาจำนวนครั้งการแลกแต้ม
    $sqlRedemptions = "SELECT COUNT(*) AS redemption_count 
        FROM redemption_history
        WHERE member_id = $member_id";

    // ประมวลผลคิวรี่และดึงข้อมูล
    $resultWeekly = $conn->query($sqlWeekly);
    $resultMonthly = $conn->query($sqlMonthly);
    $resultBestSellingProducts = $conn->query($sqlBestSellingProducts);
    $resultRedemptions = $conn->query($sqlRedemptions);

    // รับข้อมูลจากคิวรี่
    $weeklyData = $resultWeekly->fetch_assoc();
    $monthlyData = $resultMonthly->fetch_assoc();
    $bestSellingProductsData = $resultBestSellingProducts->fetch_all(MYSQLI_ASSOC);
    $redemptionsData = $resultRedemptions->fetch_assoc();

    // ปิดการเชื่อมต่อกับฐานข้อมูล
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงาน</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="icon" href="../../public/img/chakao.ico" type="image/x-icon" />
</head>

<body>
    <header>
        <div id="navbar-container"></div>
    </header>
    <div class="container mt-3">
        <h1>รายงาน</h1>

        <div class="row">
            <div class="col-md-6">
                <h2>ค่าใช้จ่ายการซื้อ</h2>
                <p>จำนวนครั้งต่อสัปดาห์: <?php echo $weeklyData['weekly_count']; ?></p>
                <p>ค่าใช้จ่ายต่อสัปดาห์: <?php echo $weeklyData['weekly_total']; ?> บาท</p>
            </div>
            <div class="col-md-6">
                <h2>สินค้าที่ถูกซื้อบ่อยที่สุด</h2>
                <ul>
                    <?php foreach ($bestSellingProductsData as $product) : ?>
                        <li><?php echo $product['product_name']; ?> (<?php echo $product['total_quantity']; ?> ชิ้น)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>ค่าใช้จ่ายการซื้อ</h2>
                <p>จำนวนครั้งต่อเดือน: <?php echo $monthlyData['monthly_count']; ?></p>
                <p>ค่าใช้จ่ายต่อเดือน: <?php echo $monthlyData['monthly_total']; ?> บาท</p>
            </div>
            <div class="col-md-6">
                <h2>การแลกแต้ม</h2>
                <p>จำนวนครั้งการแลกแต้ม: <?php echo $redemptionsData['redemption_count']; ?></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        fetch('../assets/navbar-cus.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar-container').innerHTML = data;
            });
    </script>
</body>

</html>