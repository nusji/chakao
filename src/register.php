<?php include('controller/user-regis.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <!--Link google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <!-- เพิ่ม Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="icon" href="../public/img/chakao.ico" type="image/x-icon" />
    <style>
        body {
            font-family: "Kanit", sans-serif;
            margin: 0;
            padding: 0;
            animation: gradient 10s linear infinite;
            background: linear-gradient(90deg, #00796B, #81C784, #00796B);
            background-size: 200% 100%;
        }
        .card{
            border-radius: 15px;
            box-shadow: 0px 8px 8px rgba(0, 0, 0, 0.2);
        }

        @keyframes gradient {
            0% {
                background-position: 100% 0;
            }
            100% {
                background-position: -100% 0;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">

        <h2 class="text-center" style="margin-bottom: 10px;"> <img style="width: 10%;" src="../public/img/logo-nobg.webp" alt="logo"> สมัครสมาชิก</h2>
        <div class="card bg-light p-4">
            <form method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="first_name">ชื่อ</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">นามสกุล</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                </div>
                <div class="form-row">
                    <!-- Date of Birth -->
                    <div class="form-group col-md-6">
                        <label for="datebirth">วันเดือนปีเกิด</label>
                        <input type="date" value="20/10/1990" class="form-control" id="datebirth" name="datebirth" required>
                    </div>

                </div>
                <div class="form-group">
                    <label for="address">ที่อยู่</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="sub-district">ตำบล</label>
                        <input type="text" class="form-control" id="sub-district" name="sub-district" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="district">อำเภอ</label>
                        <input type="text" class="form-control" id="district" name="district" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">จังหวัด</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="zipcode">รหัสไปรษณีย์</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="member_tel">เบอร์โทรศัพท์</label>
                    <input type="tel" class="form-control" id="member_tel" name="member_tel" pattern="[0-9]*" maxlength="10" title="กรุณากรอกหมายเลขโทรศัพท์ 10 หลัก" placeholder="กรอกหมายเลขโทรศัพท์ 10 หลัก" required>
                </div>
                <div class="form-group">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">ลงทะเบียน</button>

                <a href="login.php" class="btn btn-outline-secondary border-0 ml-1">
                    <i class="fa fa-arrow-left" style="margin-right: 5px;"></i> ย้อนกลับ
                </a>

            </form>
        </div>
    </div>

    <!-- Link เข้ารหัส Bootstrap JS และ jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
    document.querySelector('input[type="tel"]').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>

</body>

</html>