<?php
session_start();
if (!isset($_SESSION['member_tel'])) {
    header("Location: ../login.php"); // ถ้ายังไม่ล็อกอิน ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอิน
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สวัสดี!</title>
    <!--Link google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <!-- เพิ่ม Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="icon" href="../../public/img/chakao.ico" type="image/x-icon" />
    <style>
        body{
            font-family: "Kanit", sans-serif;
        }
        #bannerpoint {

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

        .btn {
            background-color: white;
            border: none;
            padding: 1rem;
            border-radius: 50%;
            transition: transform 0.2s;
            /* เพิ่มการแสดงเอฟเฟกต์ */
        }

        .btn:hover {
            transform: translateY(-5px);
            /* เมื่อโฮเวอร์ปุ่ม */
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>

    <section class="main-section">
        <div class="container">
            <h3 class="text-center mt-5">ยินดีต้อนรับ, <a class="text-warning"><?php echo $_SESSION['first_name']; ?></a></h3>

            <div id="bannerpoint" class="bg-white text-center p-4 mt-4" style="border-radius: 20px; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);">
                <?php
                if (isset($_SESSION['customer_id'])) {
                    $customer_id = $_SESSION['customer_id'];
                    include('../../config/database.php');
                    $sql = "SELECT points FROM member WHERE customer_id = $customer_id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $points = $row['points'];
                ?>
                        <h2>แต้มสะสม :</h2>
                        <p class="display-4 font-weight-bold"><?php echo $points; ?> แต้ม</p>
                <?php
                    }
                    $conn->close();
                }
                ?>
            </div>


            <div class="mt-4 text-center">
                <h3>รายการด่วน ทันใจ</h3>
                <a href="redem.php" class="btn btn-warning display-4 rounded-circle mx-3" style="background-color: white; border: none; padding: 1rem;">
                    <i class="fas fa-coins" style="color: #ffc107; font-size: 3rem;"></i>
                    <p class="mb-0" style="color: #343a40;">แลกแต้ม</p>
                </a>
                <a href="prod-list.php" class="btn btn-danger display-4 rounded-circle mx-3" style="background-color: white; border: none; padding: 1rem;">
                    <i class="fas fa-shopping-bag" style="color: #dc3545; font-size: 3rem;"></i>
                    <p class="mb-0" style="color: #343a40;">ดูรายการสินค้า</p>
                </a>
                <a href="promo.php" class="btn btn-info display-4 rounded-circle mx-3" style="background-color: white; border: none; padding: 1rem;">
                    <i class="fas fa-tags" style="color: #17a2b8; font-size: 3rem;"></i>
                    <p class="mb-0" style="color: #343a40;">ดูโปรโมชั่น</p>
                </a>
            </div>

        </div>
    </section>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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