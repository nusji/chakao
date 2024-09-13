<?php
// เรียกใช้ไฟล์เช็คสถานะเซสชัน (session-status.php)
include('../controller/session-status.php');

// คำสั่งเชื่อมต่อฐานข้อมูล
include('../../config/database.php');

// คำสั่ง SQL สำหรับดึงข้อมูลสินค้าจากตาราง "products"
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสินค้า</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="icon" href="../../public/img/chakao.ico" type="image/x-icon" />
</head>
<body>
     <!-- Navbar -->
     <header>
        <div id="navbar-container"></div>
    </header>
    <div class="container">
        <h1>รายการสินค้า</h1>

        <div class="row">
            <?php
            // ใช้ลูปเพื่อแสดงรายการสินค้า
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4">';
                echo '<div class="card mb-4 shadow-sm">';
                echo '<img class="bd-placeholder-img card-img-top" src="' . $row['product_image'] . '" alt="' . $row['product_name'] . '">';
                echo '<div class="card-body">';
                echo '<p class="card-text">' . $row['product_name'] . '</p>';
                echo '<div class="d-flex justify-content-between align-items-center">';
                echo '<div class="btn-group">';
                echo '<button id="callButton" type="button" class="btn btn-sm btn-outline-secondary">โทรสั่ง</button>';
                echo '</div>';
                echo '<small class="text-muted">ราคา: ' . $row['price'] . ' บาท</small>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <footer>
        <!-- ข้อมูลที่คุณต้องการแสดงในส่วนท้ายเว็บ (Footer) -->
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // โหลด Navbar และแสดงใน <div> ที่คุณสร้าง
        fetch('../assets/navbar-cus.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar-container').innerHTML = data;
            });
    </script>

<script>
    const callButton = document.getElementById("callButton");
    
    // เพิ่มการฟังก์ชันเมื่อปุ่มถูกคลิก
    callButton.addEventListener("click", function() {
        // โทรหมายไปยังหมายเลข 0645675605
        window.location.href = "tel:0645675605";
    });
</script>

</body>
</html>
