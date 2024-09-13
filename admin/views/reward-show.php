<?php include('../controller/session-status.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสินค้า</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: "Kanit", sans-serif;
        }

        /* เริ่มต้นสีเทา */
        .btn.btn-secondary {
            color: #7b7b7b;
            background-color: transparent;
            border: 0px;
        }

        /* เมื่อ hover ให้ข้อความเหมือนยกขึ้น */
        .btn.btn-secondary:hover {
            color: #000;
            /* สีข้อความเมื่อ hover */
            transform: translateY(-2px);
            /* ข้อความเหมือนยกขึ้น */
        }

        /* CSS สำหรับปุ่มลบสมาชิกออก */
        .delete-button {
            display: inline-block;
            border-radius: 8px;
            padding: 5px 20px;
            /* ปรับขนาดของปุ่มตามที่คุณต้องการ */
            background-color: white;
            /* สีพื้นหลังของปุ่ม */
            /* รอบขอบ */
            box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.2);
            /* เงา */
            text-decoration: none;
            /* ลบขีดเส้นใต้ข้อความ */
            color: #333;
            /* สีข้อความ */
            transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
        }

        .delete-button:hover {
            background-color: #ccc;
            /* เมื่อโฮเวอร์ปุ่ม */
            color: #fff;
            /* สีข้อความเมื่อโฮเวอร์ */
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
            /* เมื่อโฮเวอร์ */
        }

        .edit-button {
            display: inline-block;
            border-radius: 8px;
            padding: 5px 20px;
            margin-right: 10px;
            margin-bottom: 10px;
            /* ปรับขนาดของปุ่มตามที่คุณต้องการ */
            background-color: white;
            /* สีพื้นหลังของปุ่ม */
            /* รอบขอบ */
            box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.2);
            /* เงา */
            text-decoration: none;
            /* ลบขีดเส้นใต้ข้อความ */
            color: #333;
            /* สีข้อความ */
            transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
        }

        .edit-button:hover {
            background-color: #ccc;
            /* เมื่อโฮเวอร์ปุ่ม */
            color: #fff;
            /* สีข้อความเมื่อโฮเวอร์ */
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
            /* เมื่อโฮเวอร์ */
        }
    </style>

</head>

<body>
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>
    <div class="container mt-3">
        <h1 class="">รายการรางวัล</h1>

        <a href="reward-insert.php" class="btn btn-secondary" style="margin-bottom: 15px;">
            <i class="fas fa-plus"></i> เพิ่มรางวัล
        </a>

        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    <div class="form-group">
                        <label for="search-pd">ค้นหา</label>
                        <input type="text" name="search" class="form-control" placeholder="ทั้งหมด">
                    </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="order_by">เรียงตาม</label>
                    <select name="order_by" class="form-control">
                        <option value="reward_id">ID รางวัล</option>
                        <option value="reward_name">ชื่อรางวัล</option>
                        <option value="points_required">จำนวนแต้มแลก</option>
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
        <table class="table  table-striped mt-4">
            <thead>
                <tr>
                    <th scope="col">รหัสรางวัล</th>
                    <th scope="col">ชื่อรางวัล</th>
                    <th scope="col">รูปภาพ</th>
                    <th scope="col">จำนวนแต้มที่ต้องใช้</th>
                    <th scope="col">รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // เพิ่มโค้ด PHP ส่วนนี้เพื่อดึงข้อมูลจากฐานข้อมูล
                include('../../config/database.php');

                if (isset($_POST['search'])) {
                    $search = mysqli_real_escape_string($conn, $_POST['search']);
                    $order = mysqli_real_escape_string($conn, $_POST['order_by']);

                    $sql = "SELECT * FROM rewards
                    WHERE reward_name LIKE '%$search%'";

                    if ($order !== 'reward_id') {
                        $sql .= " ORDER BY $order";
                    }
                } else {
                    $sql = "SELECT *FROM rewards";
                }

                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <tr>
                            <td><?php echo $row["reward_id"]; ?></td>
                            <td><?php echo $row["reward_name"]; ?></td>
                            <td><img src='<?php echo $row["image_url"]; ?>' alt='รูปภาพสินค้า' style='max-width: 60px;' class='img-fluid'></td>
                            <td><?php echo $row["points_required"]; ?></td>
                            <td><?php echo $row["description"]; ?></td>

                            <td><a class="edit-button" href="reward-edit.php?reward_id=<?php echo $row["reward_id"]; ?>">แก้ไข</a></td>
                            <td><a class="delete-button" href="#" data-reward-id='<?php echo $row["reward_id"]; ?>'>ลบ</a></td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>ไม่พบรายการรางวัล</td></tr>";
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>

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
        document.addEventListener("DOMContentLoaded", function() {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    const productId = this.getAttribute('data-product-id');

                    Swal.fire({
                        title: 'คุณแน่ใจหรือไม่?',
                        text: 'คุณต้องการลบสินค้านี้หรือไม่?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'ใช่, ลบ!',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // ส่งคำขอลบสินค้าโดยใช้ XMLHttpRequest
                            const xhr = new XMLHttpRequest();
                            xhr.open("DELETE", `../controller/prod-delete.php?id=${productId}`, true);
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4) {
                                    if (xhr.status === 200) {
                                        const response = JSON.parse(xhr.responseText);
                                        if (response.success) {
                                            Swal.fire('ลบสำเร็จ', 'สินค้าถูกลบออกแล้ว', 'success').then(() => {
                                                location.reload(); // รีโหลดหน้าหลังจากลบสินค้า
                                            });
                                        } else {
                                            Swal.fire('เกิดข้อผิดพลาด', 'มีข้อผิดพลาดในการลบสินค้า', 'error');
                                        }
                                    }
                                }
                            };
                            xhr.send();
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>