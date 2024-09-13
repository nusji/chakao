<?php include('../controller/session-status.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

    <title>รายชื่อลูกค้า</title>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }

        /* CSS สำหรับปุ่มลบสมาชิกออก */
        .delete-button {
            display: inline-block;
            border-radius: 10px;
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
    </style>
</head>

<body>
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>

    <div class="container mt-3">
        <h1>รายชื่อสมาชิก</h1>

        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    <div class="form-group">
                        <label for="search">ค้นหาชื่อหรือเบอร์โทร</label>
                        <input type="text" class="form-control" name="search" placeholder="ทั้งหมด">
                    </div>
            </div>
            <div class="col-md-4">
                <label for="order_by">เรียงลำดับโดย</label>
                <select class="form-control" name="order_by">
                    <option value="customer_id">รหัสลูกค้า</option>
                    <option value="first_name">ชื่อ</option>
                    <option value="member_tel">เบอร์โทร</option>
                    <option value="points">แต้ม</option>
                </select>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">ค้นหา</button>
                </div>
            </div>
        </div>
        </form>
    </div>

    <table class="table">
        <thead">
            <tr>
                <th>รหัสลูกค้า</th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>เบอร์โทร</th>
                <th>แต้มที่ได้</th>
                <th>ดำเนินการ</th>
            </tr>
            </thead>
            <tbody>
                <?php
                include('../../config/database.php');
                if (isset($_POST['search'])) {
                    $search = mysqli_real_escape_string($conn, $_POST['search']);
                    $order_by = mysqli_real_escape_string($conn, $_POST['order_by']);
                    $sql = "SELECT c.customer_id, c.first_name, c.last_name, m.member_tel, m.points 
                FROM customer as c, member as m
                WHERE c.customer_id = m.customer_id
                AND (c.first_name LIKE '%$search%' OR m.member_tel LIKE '%$search%')
                ORDER BY $order_by";
                } else {
                    $order_by = 'customer_id';
                    $sql = "SELECT c.customer_id, c.first_name, c.last_name, m.member_tel, m.points 
                FROM Customer as c, member as m
                WHERE c.customer_id = m.customer_id
                ORDER BY $order_by";
                }

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <tr>
                            <td><?php echo $row["customer_id"]; ?></td>
                            <td><?php echo $row["first_name"]; ?></td>
                            <td><?php echo $row["last_name"]; ?></td>
                            <td><?php echo $row["member_tel"]; ?></td>
                            <td><?php echo $row["points"]; ?></td>
                            <td><a class="delete-button" href="#" data-customer-id='<?php echo $row["customer_id"]; ?>'>ลบสมาชิกออก</a></td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>ไม่พบรายการสมาชิก</td></tr>";
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
        // Load Navbar and display it in the 'navbar-container' div
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
                    const customerId = this.getAttribute('data-customer-id');
                    Swal.fire({
                        title: 'คุณแน่ใจหรือไม่?',
                        text: 'ในการลบสมาชิกนี้ กรุณาพิมพ์ "delete" ในช่องด้านล่าง',
                        input: 'text', // เพิ่มช่องให้พิมพ์
                        showCancelButton: true,
                        confirmButtonText: 'ใช่, ลบ!',
                        cancelButtonText: 'ยกเลิก',
                        preConfirm: (inputText) => { // ตรวจสอบค่าที่ใส่ในช่อง
                            if (inputText === 'delete') {
                                // ส่งคำขอลบสมาชิกโดยใช้ XMLHttpRequest
                                const xhr = new XMLHttpRequest();
                                xhr.open("DELETE", `../controller/memb-delete.php?id=${customerId}`, true);
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === 4) {
                                        if (xhr.status === 200) {
                                            const response = JSON.parse(xhr.responseText);
                                            if (response.success) {
                                                Swal.fire('ลบสำเร็จ', 'สมาชิกนี้ถูกลบออกแล้ว', 'success').then(() => {
                                                    location.reload(); // รีโหลดหน้าหลังจากลบสมาชิก
                                                });
                                            } else {
                                                Swal.fire('เกิดข้อผิดพลาด', 'มีข้อผิดพลาดในการลบสมาชิก', 'error');
                                            }
                                        }
                                    }
                                };
                                xhr.send();
                            } else {
                                Swal.showValidationMessage('คุณต้องพิมพ์ "delete" เพื่อยืนยันการลบ');
                            }
                        }
                    });
                });
            });
        });
    </script>

</body>

</html>