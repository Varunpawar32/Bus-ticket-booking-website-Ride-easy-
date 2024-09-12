<?php
//db connection
$conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");
//$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");

function getBuses($conn, $from, $to, $date) {

    //db connection
    $conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");
    //$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");
    
    $searchResults = []; // Replace this with your actual data retrieval logic
    $startDate = $date . ' 00:00:00';
    $endDate = $date . ' 23:59:59';

    $sql = "SELECT * FROM buses WHERE startpoint = ? AND destination = ? AND departuredt BETWEEN ? AND ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $from, $to, $startDate, $endDate);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $searchResults;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $date = $_POST['date'];

    // Call the function to get bus data based on the search parameters
    $searchResults = getBuses($conn, $from, $to, $date);

    // Return the search results as JSON
    header('Content-Type: application/json');
    echo json_encode($searchResults);
}
?>
