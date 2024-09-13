<?php
include('../controller/session-status.php');

// สร้างการเชื่อมต่อกับฐานข้อมูล (เปลี่ยนรายละเอียดตามเครื่องแม่ของคุณ)
include('../../config/database.php');

// คำสั่ง SQL เพื่อหาจำนวนครั้งและค่าใช้จ่ายการซื้อต่อสัปดาห์
$sqlWeekly = "SELECT COUNT(*) AS weekly_count, SUM(total_price) AS weekly_total 
    FROM sales 
    WHERE sales_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)";

// คำสั่ง SQL เพื่อหาจำนวนครั้งและค่าใช้จ่ายการซื้อต่อเดือน
$sqlMonthly = "SELECT COUNT(*) AS monthly_count, SUM(total_price) AS monthly_total 
    FROM sales 
    WHERE sales_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)";

// คำสั่ง SQL เพื่อหาสินค้าที่ถูกซื้อบ่อยที่สุด
$sqlBestSellingProducts = "SELECT product_name, SUM(quantity) AS total_quantity
    FROM sales_details
    GROUP BY product_name
    ORDER BY total_quantity DESC
    LIMIT 10";

// คำสั่ง SQL เพื่อหาจำนวนครั้งการแลกแต้ม
$sqlRedemptions = "SELECT COUNT(*) AS redemption_count 
    FROM redemption_history";

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <title>รายงานยอดขาย</title>
</head>

<body style="font-family: 'kanit' sans-serif;">

    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>

    <div class="container">
        <h1>รายงานยอดขาย</h1>
    </div>
    <div  >
        <div class="row ml-4">
            <div class="col-md-6">
                <h2>รายได้ต่อสัปดาห์</h2>
                <p>จำนวนขาย/สัปดาห์: <?php echo $weeklyData['weekly_count']; ?></p>
                <p>รายได้/สัปดาห์: <?php echo $weeklyData['weekly_total']; ?> บาท</p>
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

        <div class="row ml-4">
            <div class="col-md-6">
                <h2>รายได้ต่อเดือน</h2>
                <p>จำนวนขาย/สัปดาห์: <?php echo $monthlyData['monthly_count']; ?></p>
                <p>รายได้/เดือน: <?php echo $monthlyData['monthly_total']; ?> บาท</p>
            </div>
            <div class="col-md-6">
                <h2>การแลกแต้ม</h2>
                <p>จำนวนครั้งการแลกแต้ม: <?php echo $redemptionsData['redemption_count']; ?></p>
            </div>
        </div>
    </div>

    <canvas id="myChart"></canvas>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // โหลด Navbar และแสดงใน <div> ที่คุณสร้าง
        fetch('../assets/navbar.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar-container').innerHTML = data;
            });
    </script>

    <script>
        // ดึงข้อมูลจาก MySQL ด้วย PHP และสร้างข้อมูลสำหรับกราฟ
        <?php
        // ตรวจสอบการเชื่อมต่อกับฐานข้อมูล
        include('../../config/database.php');

        // สร้างคำสั่ง SQL เพื่อดึงข้อมูล
        $sql = "SELECT product_name, SUM(quantity) AS total_qty
                FROM sales_details
                GROUP BY product_name";

        // ประมวลผลคิวรี่
        $result = $conn->query($sql);

        // สร้างอาร์เรย์เพื่อเก็บข้อมูลสำหรับกราฟ
        $labels = [];
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $labels[] = $row['product_name'];
                $data[] = $row['total_qty'];
            }
        }
        ?>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>, // รายการสินค้า
                datasets: [{
                    label: 'ยอดขาย',
                    data: <?php echo json_encode($data); ?>, // ยอดขาย
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>