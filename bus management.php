<?php
// Start or resume a session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['admin_id'])) {
    echo "<script> window.location.href='admin login.php'</script>";
    // Redirect to the login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bus</title>
    <link rel="stylesheet" href="admin pages.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> 

    <!-- Bootstrap JS and jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
    <?php include("admin nav.php") ?>

    <?php
    // Database connection
    $conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");
    //$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");

    // Query for total buses
    $queryTotal = "SELECT * FROM bus";
    $resultTotal = $conn->query($queryTotal);
    $countTotal = mysqli_num_rows($resultTotal);

    // Query for AC buses
    $queryAC = "SELECT * FROM bus WHERE type = 'AC'";
    $resultAC = $conn->query($queryAC);
    $countAC = mysqli_num_rows($resultAC);

    // Query for non-AC buses
    $queryNonAC = "SELECT * FROM bus WHERE type = 'NON-AC'";
    $resultNonAC = $conn->query($queryNonAC);
    $countNonAC = mysqli_num_rows($resultNonAC);

    // Query for 30 capacity buses
    $queryCapacity30 = "SELECT * FROM bus WHERE capacity = 30";
    $resultCapacity30 = $conn->query($queryCapacity30);
    $countCapacity30 = mysqli_num_rows($resultCapacity30);

    // Query for 45 capacity buses
    $queryCapacity45 = "SELECT * FROM bus WHERE capacity = 45";
    $resultCapacity45 = $conn->query($queryCapacity45);
    $countCapacity45 = mysqli_num_rows($resultCapacity45);
    ?>

<div class="card">
    <div class="card-body">
        <p class="card-text">
            <span class="font-weight-bold">Currently Total no of buses:</span> 
            <span class="badge badge-primary"><?php echo $countTotal; ?> buses</span>
        </p>
        <p class="card-text">
            <span class="font-weight-bold">AC Buses:</span> 
            <span class="badge badge-success"><?php echo $countAC; ?></span>
        </p>
        <p class="card-text">
            <span class="font-weight-bold">Non-AC Buses:</span> 
            <span class="badge badge-warning"><?php echo $countNonAC; ?></span>
        </p>
        <p class="card-text">
            <span class="font-weight-bold">30 Capacity Buses:</span> 
            <span class="badge badge-info"><?php echo $countCapacity30; ?></span>
        </p>
        <p class="card-text">
            <span class="font-weight-bold">45 Capacity Buses:</span> 
            <span class="badge badge-secondary"><?php echo $countCapacity45; ?></span>
        </p>
    </div>
</div><br><br>


    <div class="card">
    <div class="card-header">
        Add Bus
    </div>
    <div class="card-body">
        <form id="add-bus-form" action="" method="post">
            <div class="form-group">
                <label for="bus-number">Bus number:</label>
                <input type="text" class="form-control" id="bus-number" name="number" pattern=[A-Z]{2}[0-9]{2}[A-Z]{2}[0-9]{4} title="Bus number format: XX99XX9999" required>
            </div>
            <div class="form-group">
                <label for="bus-type">Type:</label>
                <select class="form-control" id="bus-type" name="type">
                    <option value="AC">AC</option>
                    <option value="NON-AC">NON-AC</option>
                </select>
            </div>
            <div class="form-group">
                <label for="bus-capacity">Capacity:</label>
                <select class="form-control" id="bus-capacity" name="capacity">
                    <option value="30">30</option>
                    <option value="45">45</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </form>
    </div>
</div><br><br>



    <h2>Buses Information</h2>
    <br>
       <div class="table-responsive">
       <table class = "table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Bus ID</th>
                <th>Bus Number</th>
                <th>Type</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
       </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultTotal)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <?php
                        // Format the bus number
                        $formattedNumber = preg_replace("/([A-Z]{2})([0-9]{2})([A-Z]{2})([0-9]{4})/", "$1 $2 $3 $4", $row['number']);
                    ?>
                    <td><?php echo htmlspecialchars($formattedNumber); ?></td>
                    <td><?php echo htmlspecialchars($row['type']); ?></td>
                    <td><?php echo htmlspecialchars($row['capacity']); ?></td>
                    <td>
                        <a class="btn btn-primary" href="edit_bus.php?id=<?php echo htmlspecialchars($row['id']); ?>">Edit</a>
                        <a class="btn btn-danger" href="delete_bus.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this bus?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

   
    

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $no = $_POST["number"];
        $type = $_POST["type"];
        $capacity = $_POST["capacity"];

        $add = "INSERT INTO bus(number,type,capacity) VALUES('{$no}','{$type}','{$capacity}')";
        $addresult = mysqli_query($conn, $add) or die("bus not added");
        
        if ($addresult) {
            // Success message
            echo '<script>alert("Bus added successfully")</script>';
            echo "<script> window.location.href='bus management.php'</script>";

            exit();
        } else {
            // Error message
            echo '<script>alert("Failed to add bus. Please try again.")</script>';
        }
    }
    ?>
</body>
</html>
