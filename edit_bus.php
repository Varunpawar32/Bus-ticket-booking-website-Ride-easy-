<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "ride_easy_database") or die("connection failed");
//$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");
$busId = $_GET['id'];

// Prepare the SQL query
$query = "SELECT * FROM bus WHERE id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $busId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $number, $type, $capacity);
mysqli_stmt_fetch($stmt);

$bus = [
    'id' => $id,
    'number' => $number,
    'type' => $type,
    'capacity' => $capacity
];

// Close the statement
mysqli_stmt_close($stmt);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newBusNumber = strtoupper($_POST['number']);
    $newBusType = $_POST['type'];
    $newCapacity = $_POST['capacity'];
    $update = "UPDATE bus SET number=?, type=?, capacity=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $update);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssii", $newBusNumber, $newBusType, $newCapacity, $busId);
    
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
        echo '<script>alert("Bus edited successfully")</script>';
        echo"<script> window.location.href='bus management.php'</script>";
    } else {
        echo '<script>alert("Failed to edit bus")</script>';       
        echo"<script> window.location.href='bus management.php'</script>";
    }
    

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php include 'admin nav.php';?>

<div class="container">
    <h2>Edit Bus</h2>
    
    <form method="post" action="">
        <div class="form-group">
            <label for="bus_number">Bus Number:</label>
            <input type="text" class="form-control" id="bus_number" name="number" value="<?php echo htmlspecialchars($bus['number']); ?>" required>
        </div>

        <div class="form-group">
            <label for="bus_type">Bus Type:</label>
            <select class="form-control" id="bus_type" name="type" required>
                <option value="AC" <?php echo ($bus['type'] == 'AC') ? 'selected' : ''; ?>>AC</option>
                <option value="NON-AC" <?php echo ($bus['type'] == 'Non-AC') ? 'selected' : ''; ?>>NON-AC</option>
            </select>
        </div>

        <div class="form-group">
            <label for="capacity">Capacity:</label>
            <select class="form-control" id="capacity" name="capacity" required>
                <option value="30" <?php echo ($bus['capacity'] == '30') ? 'selected' : ''; ?>>30</option>
                <option value="45" <?php echo ($bus['capacity'] == '45') ? 'selected' : ''; ?>>45</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
