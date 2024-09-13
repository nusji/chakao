<?php
// เรียกใช้ไฟล์เช็คสถานะเซสชัน (session-status.php)
include('../controller/session-status.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการขาย</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>
    <div class="container mt-3">
        <h1>รายการขาย</h1>

        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    <div class="form-group">
                        <label for="search-pd">ค้นหารหัสรายการ</label>
                        <input type="text" name="search" class="form-control" placeholder="ทั้งหมด">
                    </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="order_by">เรียงตาม</label>
                    <select name="order_by" class="form-control">
                        <option value="sales_id">รหัสการขาย</option>
                        <option value="sales_date">วันที่ขาย</option>
                        <option value="total_price DESC">ราคารวม</option>
                        <option value="total_points DESC">แต้มรวม</option>
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
                    <th>รหัสการขาย</th>
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

                if (isset($_POST['search'])) {
                    $search = mysqli_real_escape_string($conn, $_POST['search']);
                    $order = mysqli_real_escape_string($conn, $_POST['order_by']);

                    $sql = "SELECT * FROM sales as s WHERE s.sales_id LIKE '%$search%'";
                    if ($order !== 'sales_id') {
                        $sql .= " ORDER BY $order";
                    }
                } else {
                    $sql = "SELECT * FROM sales as s";
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
                    <td><a href="sales-detail.php?sales_id=<?php echo $row['sales_id']; ?>">ดูรายละเอียด</a></td>
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

    <!-- เรียกใช้ Bootstrap และ jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- เรียกใช้ไฟล์ Navbar -->
    <script>
        fetch('../assets/navbar.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar-container').innerHTML = data;
            });
    </script>
</body>
</html>
