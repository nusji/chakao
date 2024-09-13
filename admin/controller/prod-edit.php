<head>
    <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
</head>
<?php
include('../../config/database.php');
// ตรวจสอบการส่งข้อมูลแก้ไข
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $points = $_POST['points'];

    // ตรวจสอบการอัปโหลดรูปภาพสินค้า
    if (isset($_FILES['product_image']) && !empty($_FILES['product_image']['name'])) {
        $image_name = $_FILES['product_image']['name'];
        $image_tmp = $_FILES['product_image']['tmp_name'];
        $image_type = $_FILES['product_image']['type'];

        // ตรวจสอบประเภทของไฟล์รูปภาพ
        $allowed_extensions = array("image/jpeg", "image/jpg", "image/png");
        if (in_array($image_type, $allowed_extensions)) {
            $image_path = "../../uploads/prod-img/" . $image_name;
            move_uploaded_file($image_tmp, $image_path);

            // อัปเดตรูปภาพสินค้าเฉพาะหากมีการอัปโหลดรูปภาพใหม่
            $update_image_query = "UPDATE Products SET product_image = '$image_path' WHERE product_id = '$product_id'";
            mysqli_query($conn, $update_image_query);
        }
    }

    // อัปเดตข้อมูลสินค้า
    $update_product_query = "UPDATE Products SET product_name = '$product_name', price = '$price', points = '$points' WHERE product_id = '$product_id'";
    $result = mysqli_query($conn, $update_product_query);

    if ($result) {
        header('Location: prod-showall.php');

    } else {
        echo "อัปเดตรายการสินค้าไม่สำเร็จ";
    }
}
?>