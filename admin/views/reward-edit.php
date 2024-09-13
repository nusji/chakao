<?php
include('../controller/session-status.php');
include('../../config/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบการส่ง reward_id ผ่านแบบฟอร์ม
    if (isset($_POST['reward_id'])) {
        $reward_id = $_POST['reward_id'];
        $reward_name = mysqli_real_escape_string($conn, $_POST['reward_name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $points_required = intval($_POST['points_required']);

        // อัปเดตข้อมูลรางวัล
        $sql_update = "UPDATE rewards SET reward_name = ?, description = ?, points_required = ? WHERE reward_id = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "ssii", $reward_name, $description, $points_required, $reward_id);

        if (mysqli_stmt_execute($stmt_update)) {
            // อัปเดตสำเร็จ
            header('Location: reward-show.php'); // ลิ้งค์กลับไปยังหน้าที่แสดงรางวัลหลังจากอัปเดต
            exit;
        } else {
            echo "การอัปเดตรางวัลล้มเหลว: " . mysqli_error($conn);
        }
    } else {
        echo "รหัสรางวัลไม่ถูกต้องหรือไม่ได้ระบุ";
    }

    mysqli_close($conn);
}

$reward_id = null;

if (isset($_GET['reward_id'])) {
    $reward_id = $_GET['reward_id'];

    // ดึงข้อมูลรางวัลจากฐานข้อมูลโดยอ้างอิง reward_id
    $sql_select = "SELECT * FROM rewards WHERE reward_id = ?";
    $stmt_select = mysqli_prepare($conn, $sql_select);
    mysqli_stmt_bind_param($stmt_select, "i", $reward_id);
    mysqli_stmt_execute($stmt_select);
    $result_select = mysqli_stmt_get_result($stmt_select);

    if ($row = mysqli_fetch_assoc($result_select)) {
        // ข้อมูลรางวัล
        $reward_name = $row['reward_name'];
        $description = $row['description'];
        $points_required = $row['points_required'];
    } else {
        echo "ไม่พบข้อมูลรางวัลที่ต้องการแก้ไข";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขรางวัล</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <header>
        <div id="navbar-container"></div>
    </header>
    <div class="container mt-5">
        <div class="text-center mt-3">
            <a href="reward-show.php" class="btn btn-outline-secondary border-0 ml-1">
                <i class="fa fa-arrow-left" style="margin-right: 5px;"></i>ย้อนกลับ
            </a>
        </div>
        <h1>แก้ไขรางวัล</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="reward_id" value="<?php echo $reward_id; ?>">
            <div class="form-group">
                <label for="reward_name">ชื่อรางวัล:</label>
                <input type="text" name="reward_name" class="form-control" required value="<?php echo $reward_name; ?>">
            </div>
            <div class="form-group">
                <label for="description">คำอธิบาย:</label>
                <textarea name="description" class="form-control" rows="4" required><?php echo $description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="points_required">แต้มที่ต้องใช้:</label>
                <input type="number" name="points_required" class="form-control" required value="<?php echo $points_required; ?>">
            </div>
            <button type="submit" class="btn btn-primary">บันทึกรางวัล</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        fetch('../assets/navbar.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar-container').innerHTML = data;
            });
    </script>
</body>

</html>