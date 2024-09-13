<?php include('../controller/session-status.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกการขาย</title>
    <!-- เพิ่ม Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">


</head>

<body>
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>
    <div class="container mt-3">
        <h1>บันทึกการขาย</h1>
        <form id="salesForm">
            <div class="form-group">
                <label for="salesDate">วันที่และเวลา:</label>
                <input type="datetime-local" class="form-control" id="salesDate" required>
            </div>
            <div class="form-group">
                <label for="productSelect">เลือกสินค้า:</label>
                <select class="form-control" id="productSelect">
                    <option value="">กรุณาเลือก</option>
                    <!-- ดึงรายการสินค้าจากฐานข้อมูลและแสดงเป็นตัวเลือก -->
                    <?php
                    include('../../config/database.php');
                    $sql = "SELECT * FROM products";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row["product_id"]}|{$row["product_name"]}|{$row["price"]}|{$row["points"]}'>{$row["product_name"]} (ราคา: {$row["price"]} บาท, แต้ม: {$row["points"]})</option>";
                        }
                    } else {
                        echo "0 results";
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <button class="btn btn-primary" onclick="addProductToCart()">เพิ่มในรายการ</button>
            <ul id="cartList" class="list-group mt-3"></ul>
            <div class="form-group mt-3">
                <label for="totalAmount">รวมราคาทั้งหมด (บาท):</label>
                <span id="totalAmount">0.00</span>
            </div>
            <div class="form-group">
                <label for="totalPoints">รวมแต้มทั้งหมด:</label>
                <span id="totalPoints">0</span>
            </div>
            <div class="form-group">
                <label for="memberTel">เบอร์โทรลูกค้า : <span class="small text-muted">**กรณีไม่ได้เป็นสมาชิกกรอก 00</span></label>
                <input type="text" class="form-control" id="memberTel" placeholder="" required>
            </div>
            <button class="btn btn-success" onclick="submitSales()">บันทึกการขาย</button>
        </form>
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
        // เพิ่ม JavaScript สำหรับการเพิ่มสินค้าในรายการสินค้า และการบันทึกข้อมูลลงในฐานข้อมูล
        // เพิ่มสินค้าในรายการ
        function addProductToCart() {
            const productSelect = document.getElementById('productSelect');
            const cartList = document.getElementById('cartList');
            const totalAmount = document.getElementById('totalAmount');
            const totalPoints = document.getElementById('totalPoints');

            const selectedProduct = productSelect.options[productSelect.selectedIndex];
            if (selectedProduct.value === '') return; // ไม่เลือกสินค้า

            const productInfo = selectedProduct.value.split('|');
            const product_id = productInfo[0]; // เพิ่มการดึง product_id จากค่าที่เลือก
            const product_name = productInfo[1];
            const price = parseFloat(productInfo[2]);
            const points = parseInt(productInfo[3]);

            // ตรวจสอบว่าสินค้ามีอยู่ในตะกร้าแล้วหรือไม่
            let existingItem = null;
            for (const item of cartList.children) {
                if (item.dataset.product_id === product_id) {
                    existingItem = item;
                    break;
                }
            }

            if (existingItem) {
                // ถ้ามีสินค้าอยู่แล้วในตะกร้า ให้เพิ่มจำนวน
                const quantityInput = existingItem.querySelector('.quantity-input');
                const quantity = parseInt(quantityInput.value);
                quantityInput.value = quantity + 1;
            } else {
                // ถ้าสินค้ายังไม่มีอยู่ในตะกร้า ให้สร้างรายการใหม่
                const item = document.createElement('li');
                item.dataset.product_id = product_id;
                item.innerHTML = `
            ${product_name} (ราคา: ${price.toFixed(2)} บาท, แต้ม: ${points})
            <input type="number" class="quantity-input" value="1" min="1" readonly>
            <button class="btn btn-danger btn-sm" onclick="removeProduct(this)">ลบ</button>
        `;
                cartList.appendChild(item);
            }

            // คำนวณรวมราคาและแต้ม
            let totalPrice = 0;
            let totalPointsValue = 0;
            for (const item of cartList.children) {
                const quantityInput = item.querySelector('.quantity-input');
                const quantity = parseInt(quantityInput.value);
                totalPrice += price * quantity;
                totalPointsValue += points * quantity;
            }

            totalAmount.textContent = totalPrice.toFixed(2);
            totalPoints.textContent = totalPointsValue;
        }

        // ลบสินค้าออกจากรายการ
        function removeProduct(button) {
            const cartList = document.getElementById('cartList');
            const totalAmount = document.getElementById('totalAmount');
            const totalPoints = document.getElementById('totalPoints');

            const item = button.parentElement;
            const quantityInput = item.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value);

            const productInfo = item.textContent.match(/ราคา: ([\d.]+) บาท, แต้ม: (\d+)/);
            const price = parseFloat(productInfo[1]);
            const points = parseInt(productInfo[2]);

            if (quantity > 1) {
                quantityInput.value = quantity - 1;
            } else {
                cartList.removeChild(item);
            }

            let totalPrice = parseFloat(totalAmount.textContent) - price;
            let totalPointsValue = parseInt(totalPoints.textContent) - points;

            totalAmount.textContent = totalPrice.toFixed(2);
            totalPoints.textContent = totalPointsValue;
        }

        // บันทึกการขาย
        function submitSales() {
            const memberTel = document.getElementById('memberTel').value;
            const salesDate = document.getElementById('salesDate').value;
            const cartList = document.getElementById('cartList');

            if (memberTel === '' || salesDate === '' || cartList.children.length === 0) {
                // ใช้ SweetAlert แทน alert
                Swal.fire('ข้อมูลไม่ครบถ้วน', 'โปรดกรอกข้อมูลให้ครบถ้วน', 'error');
            } else {
                const salesData = {
                    memberTel: memberTel,
                    salesDate: salesDate,
                    items: []
                };

                for (const item of cartList.children) {
                    const productInfo = item.textContent.match(/(.+) \(ราคา: ([\d.]+) บาท, แต้ม: (\d+)\)/);
                    const itemName = productInfo[1];
                    const price = parseFloat(productInfo[2]);
                    const points = parseInt(productInfo[3]);
                    const quantity = parseInt(item.querySelector('.quantity-input').value);
                    const product_id = item.dataset.product_id; // เพิ่มการดึง product_id

                    salesData.items.push({
                        product_id: product_id, // เพิ่ม product_id
                        itemName: itemName,
                        price: price,
                        points: points,
                        quantity: quantity
                    });
                }

                // ส่งข้อมูลการขายไปยังเซิร์ฟเวอร์โดยใช้ AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '../controller/purchase-add.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        alert(xhr.responseText);
                        setTimeout(function() {
                            location.reload(); // รีโหลดหน้าเพื่อรีเซ็ตข้อมูล
                        }, 2000); // 2 วินาที

                    }
                };
                xhr.send(JSON.stringify(salesData));
            }
        }
    </script>

</body>

</html>