<?php
include 'admin nav.php';
$conn = mysqli_connect("localhost", "root", "", "ride_easy_database") or die("connection failed");
//$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $tripId = $_GET['id'];

    // Check if the trip exists
    $checkQuery = "SELECT * FROM trip WHERE id = ?";
    $checkStmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, "i", $tripId);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        // Trip exists, proceed with deletion
        $deleteQuery = "DELETE FROM trip WHERE id = ?";
        $deleteStmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($deleteStmt, "i", $tripId);
        $success = mysqli_stmt_execute($deleteStmt);

        mysqli_stmt_close($deleteStmt);

        if ($success) {
            // Redirect to the display page after successful deletion
            header("Location: trip management.php");
            exit();
        } else {
            echo "Error deleting trip.";
        }
    } else {
        // Redirect to the display page if the trip is not found
        header("Location: trip management.php");
        exit();
    }

    mysqli_stmt_close($checkStmt);
} else {
    // Redirect to the display page if no ID is provided
    header("Location: trip management.php");
    exit();
}

mysqli_close($conn);
?>
