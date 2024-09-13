<?php
// เรียกใช้ไฟล์เช็คสถานะเซสชัน (session-status.php)
include('../controller/session-status.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แลกแต้ม</title>
    <link rel="icon" href="../../public/img/chakao.ico" type="image/x-icon" />
    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- เรียกใช้ SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        #special-section {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #special-section img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>
    <section id="special-section">
        <img src="../assets/special.webp" alt="specials">
    </section>

    <div class="container mt-3 text-center">
        <h1 class="text-center lg">แลกแต้ม</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include('../../config/database.php');
            $reward_id = intval($_POST['reward_id']);
            $member_id = $_SESSION['member_id'];

            // ดึงค่าแต้มที่สมาชิกมีจากฐานข้อมูล
            $sql_points = "SELECT points FROM member WHERE member_id = ?";
            $stmt_points = mysqli_prepare($conn, $sql_points);
            mysqli_stmt_bind_param($stmt_points, "i", $member_id);
            mysqli_stmt_execute($stmt_points);
            mysqli_stmt_bind_result($stmt_points, $available_points);

            if (mysqli_stmt_fetch($stmt_points)) {
                // ค่า $available_points จะมีค่าจากฐานข้อมูล
                mysqli_stmt_close($stmt_points); // ปิด statement
            } else {
                echo "เกิดข้อผิดพลาดในการดึงค่าแต้มสมาชิก";
            }

            // ดึงค่าแต้มที่ต้องใช้สำหรับรางวัลที่ถูกเลือก
            $sql_required_points = "SELECT points_required FROM rewards WHERE reward_id = ?";
            $stmt_required_points = mysqli_prepare($conn, $sql_required_points);
            mysqli_stmt_bind_param($stmt_required_points, "i", $reward_id);
            mysqli_stmt_execute($stmt_required_points);
            mysqli_stmt_bind_result($stmt_required_points, $required_points);

            if (mysqli_stmt_fetch($stmt_required_points)) {
                // ค่า $required_points จะมีค่าจากฐานข้อมูล
                mysqli_stmt_close($stmt_required_points); // ปิด statement
            } else {
                echo "เกิดข้อผิดพลาดในการดึงค่าแต้มที่ต้องใช้สำหรับรางวัลที่เลือก";
            }

            if ($available_points >= $required_points) {
                $remaining_points = $available_points - $required_points;
                $sql_update_points = "UPDATE member SET points = ? WHERE member_id = ?";
                $stmt_update_points = mysqli_prepare($conn, $sql_update_points);
                mysqli_stmt_bind_param($stmt_update_points, "ii", $remaining_points, $member_id);

                if (mysqli_stmt_execute($stmt_update_points)) {
                    $sql_add_redemption = "INSERT INTO redemption_history (redemption_date, member_id, reward_id, redeemed_points) VALUES (NOW(),?, ?, ?)";
                    $stmt_add_redemption = mysqli_prepare($conn, $sql_add_redemption);
                    mysqli_stmt_bind_param($stmt_add_redemption, "iii", $member_id, $reward_id, $required_points);

                    if (mysqli_stmt_execute($stmt_add_redemption)) {
                        echo '<script>';
                        echo 'Swal.fire("สำเร็จ!", "การดำเนินการเสร็จสมบูรณ์", "success").then(function() {window.location.href = "dashboard.php"});';
                        echo '</script>';
                    } else {
                        echo '<script>';
                        echo 'Swal.fire("เกิดข้อผิดพลาด", "ในการบันทึกรายการแลกแต้ม", "error");';
                        echo '</script>';
                    }
                } else {
                    echo '<script>';
                    echo 'Swal.fire("เกิดข้อผิดพลาด", "ในการอัปเดตค่าแต้ม", "error");';
                    echo '</script>';
                }
            } else {
                // แสดง SweetAlert ในกรณีที่แต้มไม่เพียงพอ
                echo '<script>';
                echo 'Swal.fire("แต้มไม่เพียงพอ", "คุณมีแต้มไม่เพียงพอสำหรับรางวัลนี้", "warning");';
                echo '</script>';
            }
        }
        ?>

        <form method="POST">
            <div class="form-group">
                <label for="reward_id">เลือกรางวัลที่ต้องการแลก :</label>
                <select name="reward_id" class="form-control">
                    <?php
                    // ดึงรายการรางวัลจากฐานข้อมูล
                    include('../../config/database.php');
                    $sql_rewards = "SELECT reward_id, reward_name, points_required FROM rewards";
                    $result_rewards = $conn->query($sql_rewards);

                    if ($result_rewards->num_rows > 0) {
                        while ($row_rewards = $result_rewards->fetch_assoc()) {
                            echo "<option value='" . $row_rewards['reward_id'] . "'>" . $row_rewards['reward_name'] . " (" . $row_rewards['points_required'] . " แต้ม)</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">แลกแต้ม</button>
        </form>
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
