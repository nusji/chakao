<?php include('../controller/session-status.php'); ?>
<?php
include('../../config/database.php');
// ดึงข้อมูลสินค้าที่ต้องการแก้ไข
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $get_product_query = "SELECT * FROM Products WHERE product_id = '$product_id'";
    $product_result = mysqli_query($conn, $get_product_query);

    if (mysqli_num_rows($product_result) > 0) {
        $product = mysqli_fetch_assoc($product_result);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/bootstrap-icons/1.18.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <title>แก้ไขรายการสินค้า</title>
</head>

<body style="font-family: 'Kanit', sans-serif;">
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>
    <div class="container mt-5">
        <div class="text-center mt-3">
            <a href="prod-showall.php" class="btn btn-outline-secondary border-0 ml-1">
                <i class="fa fa-arrow-left" style="margin-right: 5px;"></i>ย้อนกลับ
            </a>
        </div>
        <h1 class="text-center">แก้ไขรายการสินค้า <i class="bi-cart"></i></h1>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <div class="form-group">
                <label for="product_name">ชื่อสินค้า:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_image" class="col-form-label">รูปภาพสินค้า:</label>
                <input type="file" id="product_image" name="product_image" accept="image/*" style="display:none;">
                <input type="button" value="อัปโหลดจากไฟล์" onclick="document.getElementById('product_image').click();" class="form-control streched-link">
            </div>
            <div class="form-group">
                <label for="display_image" class="col-form-label">รูปภาพที่เลือก:</label>
                <img id="display_image" src="<?php echo $product['product_image']; ?>" alt="รูปภาพสินค้า" style="max-width:100px; height: 100px;">
            </div>
            <div class="form-group">
                <label for="price">ราคา:</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" min="0" step="0.01" value="<?php echo $product['price']; ?>" required>
                <small class="form-text text-muted">ระบุราคา</small>
            </div>
            <div class="form-group">
                <label for="points">แต้มที่ได้รับ:</label>
                <input type="number" class="form-control" id="points" name="points" min="0" value="<?php echo $product['points']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
        </form>
    </div>

    <?php //ส่งฟอร์มบันทึก
    include('../controller/prod-edit.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        document.getElementById('product_image').addEventListener('change', displaySelectedImage);

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