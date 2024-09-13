<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรโมชั่น</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <!-- เรียกใช้ CSS สำหรับสไตล์เพิ่มเติม -->
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: "Kanit", sans-serif;
        }

        /* สไตล์สำหรับ promo-card */
        .promo-card {
            background-color: #f8f9fa;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* สไตล์สำหรับ footer */
        footer {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>

    <!-- Content -->
    <section class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="promo-card">
                    <h2>โปรโมชั่นที่ 1</h2>
                    <p><img style="width: 100%;" src="../assets/special.webp" alt=""></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="promo-card">
                    <h2>โปรโมชั่นที่ 2</h2>
                    <p>เร็วๆนี้</p>
                </div>
            </div>
        </div>
    </section>


    <!-- เรียกใช้ Bootstrap และ jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
        // โหลด Navbar และแสดงใน <div> ที่คุณสร้าง
        fetch('../assets/navbar-cus.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar-container').innerHTML = data;
            });
    </script>
</body>

</html>