<?php
// เรียกใช้ไฟล์เช็คสถานะเซสชัน (session-status.php)
include('../controller/session-status.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการแลกแต้ม</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>

    <div class="container mt-3">
        <h1>รายการแลกแต้ม</h1>

        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    <div class="form-group">
                        <label for="search-redemption">ค้นหารหัสรายการ</label>
                        <input type="text" name="search" class="form-control" placeholder="ทั้งหมด">
                    </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="order_by">เรียงตาม</label>
                    <select name="order_by" class="form-control">
                        <option value="redemption_id">รหัสการแลกแต้ม</option>
                        <option value="redemption_date">วันที่แลกแต้ม</option>
                        <option value="redeemed_points DESC">แต้มที่แลก</option>
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
        <!-- เพิ่มตารางสำหรับรายการแลกแต้มที่นี่ -->
        <table class="table">
            <thead>
                <tr>
                    <th>รหัสการแลกแต้ม</th>
                    <th>รหัสสมาชิก</th>
                    <th>รหัสรางวัล</th>
                    <th>วันที่แลกแต้ม</th>
                    <th>แต้มที่แลก</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // เรียกใช้ไฟล์เชื่อมกับฐานข้อมูล (database.php)
                include('../../config/database.php');

                if (isset($_POST['search'])) {
                    $search = mysqli_real_escape_string($conn, $_POST['search']);
                    $order = mysqli_real_escape_string($conn, $_POST['order_by']);

                    $sql = "SELECT * FROM redemption_history as r WHERE r.redemption_id LIKE '%$search%'";
                    if ($order !== 'redemption_id') {
                        $sql .= " ORDER BY $order";
                    }
                } else {
                    $sql = "SELECT * FROM redemption_history as r";
                }
                // ประมวลผลคิวรี่
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['redemption_id']; ?></td>
                    <td><?php echo $row['member_id']; ?></td>
                    <td><?php echo $row['reward_id']; ?></td>
                    <td><?php echo $row['redemption_date']; ?></td>
                    <td><?php echo $row['redeemed_points']; ?></td>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='5'>ไม่พบรายการแลกแต้ม</td></tr>";
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
    <script>
        // โหลด Navbar และแสดงใน <div> ที่คุณสร้าง
        fetch('../assets/navbar.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar-container').innerHTML = data;
            });
    </script>

</body>
</html>
