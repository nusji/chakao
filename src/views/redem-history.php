<?php
// เรียกใช้ไฟล์เช็คสถานะเซสชัน (session-status.php)
include('../controller/session-status.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติแลกแต้ม</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="icon" href="../../public/img/chakao.ico" type="image/x-icon" />
</head>
<body>
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>
    <div class="container mt-3">
        <h1>ประวัติแลกแต้ม</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>รหัสการแลกแต้ม</th>
                    <th>รางวัล</th>
                    <th>แต้มที่ใช้</th>
                    <th>วันที่แลก</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // เรียกใช้ไฟล์เชื่อมกับฐานข้อมูล (database.php)
                include('../../config/database.php');
                $member_id = $_SESSION['member_id'];

                // ดึงรายการประวัติแลกแต้มของผู้ใช้
                $sql_history = "SELECT rh.redemption_id, r.reward_name, rh.redeemed_points, rh.redemption_date
                               FROM redemption_history rh
                               INNER JOIN rewards r ON rh.reward_id = r.reward_id
                               WHERE rh.member_id = ?";

                $stmt_history = mysqli_prepare($conn, $sql_history);
                mysqli_stmt_bind_param($stmt_history, "i", $member_id);
                mysqli_stmt_execute($stmt_history);
                mysqli_stmt_bind_result($stmt_history, $redemption_id, $reward_name, $redeemed_points, $redemption_date);

                while (mysqli_stmt_fetch($stmt_history)) {
                    echo "<tr>";
                    echo "<td>" . $redemption_id . "</td>";
                    echo "<td>" . $reward_name . "</td>";
                    echo "<td>" . $redeemed_points . "</td>";
                    echo "<td>" . $redemption_date . "</td>";
                    echo "</tr>";
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
        fetch('../assets/navbar-cus.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar-container').innerHTML = data;
            });
    </script>
</body>
</html>
