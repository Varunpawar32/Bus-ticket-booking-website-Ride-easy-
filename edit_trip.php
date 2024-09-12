<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    echo "<script> window.location.href='admin login.php'</script>";
    exit();
}

include 'admin nav.php'; 

$conn = mysqli_connect("localhost", "root", "", "ride_easy_database") or die("connection failed");
//$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");
$tripId = $_GET['id'];


// Prepare the SQL query
$query = "SELECT * FROM trip WHERE id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $tripId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $startpoint, $destination, $departuredatetime, $arrivaldatetime, $price, $bus_id);
mysqli_stmt_fetch($stmt);

// Store the fetched data in an associative array
$trip = [
    'id' => $id,
    'startpoint' => $startpoint,
    'destination' => $destination,
    'departuredt' => $departuredatetime,
    'arrivaldt' => $arrivaldatetime,
    'price' => $price,
    'bus_id' => $bus_id
];

mysqli_stmt_close($stmt);


    // Retrieve bus details for dropdown
    $busQuery = "SELECT * FROM bus";
    $busResult = mysqli_query($conn, $busQuery);


// Handle form submission to update trip details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newStartingPoint = strtoupper($_POST['starting_point']);
    $newDestination = strtoupper($_POST['destination']);
    $newDepartureDateTime = $_POST['departure_datetime'];
    $newArrivalDateTime = $_POST['arrival_datetime'];
    $newPrice = $_POST['price'];
    $newBusId = $_POST['bus_id'];

    // Update the trip details in the database
    $updateQuery = "UPDATE trip SET startpoint = ?, destination = ?, departuredt = ?, 
                    arrivaldt = ?, price = ?, bus_id = ? WHERE id = ?";
    
    $updateStmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param(
        $updateStmt,
        "ssssiii",
        $newStartingPoint,
        $newDestination,
        $newDepartureDateTime,
        $newArrivalDateTime,
        $newPrice,
        $newBusId,
        $tripId
    );
    $result = mysqli_stmt_execute($updateStmt);
    
    if ($result) {
        echo '<script>alert("Bus edited successfully")</script>';
        echo"<script> window.location.href='bus management.php'</script>";
    } else {
        echo '<script>alert("Failed to edit bus")</script>';       
        echo"<script> window.location.href='bus management.php'</script>";
    }
    mysqli_stmt_close($updateStmt);  
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit Trip</title>
</head>

<body>
    <h2>Edit Trip</h2>
    <table>
        <form method="post" action="">
            <tr>
                <td><label for="starting_point">Starting Point:</label>
                    <input type="text" id="starting_point" name="starting_point" value="<?php echo htmlspecialchars($trip['startpoint']); ?>" required>
                </td>
                <td>
                    <label for="destination">Destination:</label>
                    <input type="text" id="destination" name="destination" value="<?php echo htmlspecialchars($trip['destination']); ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="departure_datetime">Departure DateTime:</label>
                    <input type="datetime-local" id="departure_datetime" name="departure_datetime" value="<?php echo htmlspecialchars($trip['departuredt']); ?>" required>
                </td>
                <td>
                    <label for="arrival_datetime">Arrival DateTime:</label>
                    <input type="datetime-local" id="arrival_datetime" name="arrival_datetime" value="<?php echo htmlspecialchars($trip['arrivaldt']); ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($trip['price']); ?>" required>
                </td>
                <td>
                    <label for="bus_id">Bus:</label>
                    <select id="bus_id" name="bus_id" required>
                        <?php
                        while ($bus = mysqli_fetch_assoc($busResult)) {
                            echo "<option value='" . $bus['id'] . "' " . ($trip['bus_id'] == $bus['id'] ? 'selected' : '') . ">" . $bus['id'] . '-' . $bus['number'] . ' (' . $bus['type'] . ' - ' . $bus['capacity'] . ')' . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><button type="submit">Update</button></td>
            </tr>
        </form>
    </table>
</body>

</html>