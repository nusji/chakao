<?php
session_start();
if (!isset($_SESSION['member_tel'])) {
    header("Location: ../login.php"); // ถ้ายังไม่ล็อคอิน ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอิน
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการสั่งซื้อ</title>
    <!--Link google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <!-- เพิ่ม Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="icon" href="../../public/img/chakao.ico" type="image/x-icon" />
    <style>
        body {
            font-family: "Kanit", sans-serif;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>

    <div class="container mt-3">
        <h1>ประวัติการซื้อ</h1>
        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    <div class="form-group">
                        <label for="search-pd">ค้นหาสินค้า</label>
                        <input type="text" name="search" class="form-control" placeholder="ค้นหาตามรหัสรายการ">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="order_by">เรียงตาม</label>
                        <select name="order_by" class="form-control">
                            <option value="sales_id">รหัสการซื้อ</option>
                            <option value="sales_date">วันที่ซื้อ</option>
                            <option value="total_price DESC">ราคารวม (มากไปน้อย)</option>
                            <option value="total_price ASC">ราคารวม (น้อยไปมาก)</option>
                            <option value="total_points DESC">แต้มรวม (มากไปน้อย)</option>
                            <option value="total_points ASC">แต้มรวม (น้อยไปมาก)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">ค้นหา</button>
                    </div>
                </div>
                </form>
            </div>
            <!-- เพิ่มตารางสำหรับรายการขายที่นี่ -->
            <table class="table">
                <thead>
                    <tr>
                        <th>รหัสการซื้อ</th>
                        <th>วันที่และเวลา</th>
                        <th>ราคารวม (บาท)</th>
                        <th>แต้มทั้งหมด</th>
                        <th>ดูรายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // เรียกใช้ไฟล์เชื่อมกับฐานข้อมูล (database.php)
                    include('../../config/database.php');
                    $member_id = $_SESSION['member_id'];
                    if (isset($_POST['search'])) {
                        $search = mysqli_real_escape_string($conn, $_POST['search']);
                        $order = mysqli_real_escape_string($conn, $_POST['order_by']);

                        $sql = "SELECT s.sales_id, s.sales_date, s.total_price, s.total_points, d.product_name, d.price, d.points, d.quantity
                                FROM sales AS s
                                JOIN sales_details AS d ON s.sales_id = d.sales_id
                                JOIN member AS m ON s.member_id = m.member_id
                                WHERE s.sales_id LIKE '%$search%' AND m.member_id = $member_id";

                        if ($order !== 'sales_id') {
                            $sql .= " ORDER BY $order";
                        }
                    } else {
                        $sql = "SELECT s.sales_id, s.sales_date, s.total_price, s.total_points, d.product_name, d.price, d.points, d.quantity
                                FROM sales AS s
                                JOIN sales_details AS d ON s.sales_id = d.sales_id
                                JOIN member AS m ON s.member_id = m.member_id
                                WHERE m.member_id = $member_id";
                    }

                    // ประมวลผลคิวรี่
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $row['sales_id']; ?></td>
                                <td><?php echo $row['sales_date']; ?></td>
                                <td><?php echo $row['total_price']; ?></td>
                                <td><?php echo $row['total_points']; ?></td>
                                <td><a href="purchase-details.php?sales_id=<?php echo $row['sales_id']; ?>">ดูรายละเอียด</a></td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='5'>ไม่พบรายการขาย</td></tr>";
                    }

                    // ปิดการเชื่อมต่อกับฐานข้อมูล
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

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
    </body>

    </html>
