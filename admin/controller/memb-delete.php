
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../admin-login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Include your database connection
    include('../../config/database.php');

    // Check if the 'id' parameter is set in the URL
    if (isset($_GET['id'])) {
        $customer_id = mysqli_real_escape_string($conn, $_GET['id']);

        $deleteMemberSql = "DELETE FROM member WHERE customer_id = '$customer_id'";
        $deleteCustomerSql = "DELETE FROM customer WHERE customer_id = '$customer_id'";

        // ทำการลบสมาชิกจากฐานข้อมูล
        if (mysqli_query($conn, $deleteMemberSql) && mysqli_query($conn, $deleteCustomerSql) ) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        // Close the database connection
        mysqli_close($conn);

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // 'id' parameter is not set
        $response = ['success' => false, 'error' => 'Product ID not provided'];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    exit;
}
?>
