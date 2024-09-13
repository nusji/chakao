<?php include('../controller/session-status.php');
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../../config/database.php');
    if (isset($_FILES["reward_image"]) && $_FILES["reward_image"]["error"] == 0) {
        $image_tmp = $_FILES["reward_image"]["tmp_name"];
        $image_name = $_FILES["reward_image"]["name"];
        $image_data = file_get_contents($image_tmp);

        // บันทึกไฟล์ภาพลงในเซิร์ฟเวอร์
        $upload_directory = "../../uploads/reward-img/"; // โฟลเดอร์ที่จะบันทึกไฟล์
        $new_image_name = $upload_directory . uniqid() . "_" . $image_name;
        move_uploaded_file($image_tmp, $new_image_name);
    }
    $reward_name = mysqli_real_escape_string($conn, $_POST['reward_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $points_required = intval($_POST['points_required']);

    // ตรวจสอบ dup นี้มีอยู่แล้วหรือไม่
    $sql_check = "SELECT * FROM rewards WHERE reward_name = '$reward_name' ";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
?>
        <script>
            Swal.fire({
                title: 'มีรางวัลนี้แล้ว!',
                text: 'ไม่สารถเพิ่มรายการได้ เนื่องจากมีแล้ว',
                icon: 'error',
                showConfirmButton: false
            })
        </script>
        <?php
    } else {

        $sql_add = "INSERT INTO rewards (reward_name, description, points_required, image_url) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_add);
        mysqli_stmt_bind_param($stmt, "ssis", $reward_name, $description, $points_required, $new_image_name);

        if (mysqli_stmt_execute($stmt)) {
        ?>
            <script>
                Swal.fire('สำเร็จ', 'การบันทึกรางวัลสำเร็จ', 'success');
            </script>
<?php
        } else {
            echo "การเพิ่มรายการสินค้าล้มเหลว: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มรางวัลใหม่</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- เรียกใช้ SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

</head>

<body>
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>
    <div class="container mt-5">
        <div class="text-center mt-3">
            <a href="reward-show.php" class="btn btn-outline-secondary border-0 ml-1">
                <i class="fa fa-arrow-left" style="margin-right: 5px;"></i>ย้อนกลับ
            </a>
        </div>
        <h1>เพิ่มรางวัลใหม่</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="reward_name">ชื่อรางวัล:</label>
                <input type="text" name="reward_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">คำอธิบาย:</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="points_required">แต้มที่ต้องใช้:</label>
                <input type="number" name="points_required" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reward_image" class="col-form-label">รูปภาพสินค้า:</label>
                <input type="file" id="reward_image" name="reward_image" accept="image/*" style="display:none;" required class="form-control streched-link">

                <input type="button" value="อัปโหลดจากไฟล์" onclick="document.getElementById('reward_image').click();" class="form-control streched-link">
            </div>

            <div class="form-group">
                <label for="display_image" class="col-form-label">รูปภาพที่เลือก:</label>
                <img id="display_image" src="#" alt="รูปภาพสินค้า" style="max-width:100px; height: 100px;">

            </div>

            <button type="submit" class="btn btn-primary">บันทึกรางวัล</button>
        </form>
    </div>

    <!-- เรียกใช้ Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- เรียกใช้ SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // โหลด Navbar และแสดงใน <div> ที่คุณสร้าง
        fetch('../assets/navbar.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar-container').innerHTML = data;
            });
    </script>

    <script>
        // เรียกใช้ฟังก์ชัน displaySelectedImage เมื่อมีการเลือกรูปภาพ
        document.getElementById('reward_image').addEventListener('change', displaySelectedImage);

        function displaySelectedImage(event) {
            const fileInput = event.target;
            const displayImage = document.getElementById('display_image');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    displayImage.src = e.target.result;
                    // แสดงรูปภาพที่ถูกเลือก
                    displayImage.style.display = 'block';
                };

                // อ่านรูปภาพที่ถูกเลือก
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>

</body>

</html>