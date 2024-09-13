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
        $product_id = mysqli_real_escape_string($conn, $_GET['id']);

        // Query to delete the product with the specified id
        $delete_query = "DELETE FROM products WHERE product_id = $product_id";

        if (mysqli_query($conn, $delete_query)) {
            // Product deleted successfully
            $response = ['success' => true];
        } else {
            // Error occurred while deleting the product
            $response = ['success' => false, 'error' => mysqli_error($conn)];
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
