<?php
include 'admin nav.php'; // Make sure to include the appropriate navigation file

$conn = mysqli_connect("localhost", "root", "", "ride_easy_database") or die("connection failed");
//$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $busId = $_GET['id'];

    // Delete bus based on the provided ID
    $deleteQuery = "DELETE FROM bus WHERE id = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($deleteStmt, "i", $busId);
    $success = mysqli_stmt_execute($deleteStmt);

    mysqli_stmt_close($deleteStmt);

    if ($success) {
        // Redirect to the display page after successful deletion
        header("Location: bus management.php");
        exit();
    } else {
        echo "Error deleting bus.";
    }
} else {
    // Redirect to the display page if no ID is provided
    header("Location: bus management.php");
    exit();
}

mysqli_close($conn);
?>
