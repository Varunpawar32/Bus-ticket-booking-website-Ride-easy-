<?php
// Start or resume a session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['admin_id'])) {
    echo"<script> window.location.href='admin login.php'</script>";
    // Redirect to the login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>manage trip</title>
    <link rel="stylesheet" href="admin pages.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> 

    <!-- Bootstrap JS and jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php include ("admin nav.php")?>
    <?php

    //db connection
     $conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");
    //$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");


    //query bus id retrival
    $query = "SELECT * FROM bus";
    $result =  $conn->query($query);
    if ($result) {
        $busid = mysqli_fetch_all($result,MYSQLI_ASSOC);
        
    }
    else {
        $busid = [];
    }

    //query triptotal
    $query1 = "SELECT * FROM trip";
    $result1 =  $conn->query($query1);
    $count1 = mysqli_num_rows($result1);
    ?>


<br><div class="card">
    <div class="card-body">
        <p class="card-text">
            <span class="font-weight-bold">Currently Total no of trips:</span> 
            <span class="badge badge-primary"><?php echo $count1; ?> trips</span>
    </p>
    </div>
</div>   <br><br>


<div class="card">
    <div class="card-header">
        Add Trips
    </div>
    <div class="card-body">
<div class="container">
    <form id="add-trip-form" action="" method="POST">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="start-point">Starting Point:</label>
                    <input type="text" class="form-control" id="start-point" name="start_point" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="destination">Destination:</label>
                    <input type="text" class="form-control" id="destination" name="destination" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="departure-datetime">Departure Date Time:</label>
                    <input type="datetime-local" class="form-control" id="departure-datetime" name="departure_datetime" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="arrival-datetime">Arrival Date Time:</label>
                    <input type="datetime-local" class="form-control" id="arrival-datetime" name="arrival_datetime" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="price">Price (Rs):</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="bus-id">Bus:</label>
                    <select class="form-control" id="bus-id" name="bus_id">
                        <?php foreach ($busid as $bus): ?>
                            <option value="<?php echo htmlspecialchars($bus['id']); ?>"><?php echo htmlspecialchars($bus['id'].'-'.$bus['number'].'-'.$bus['type'].'-'.$bus['capacity']); ?></option>
                        <?php endforeach; ?>    
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Trip</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
</div></div></div><br><br>



<?php
//retriving data table
//compiling in table format
?>
    <div class="container">
    <h2>Trips</h2>
       <div class="table-responsive">
       <table class = "table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Trip ID</th>
                <th scope="col">Starting Point</th>
                <th scope="col">Destination</th>
                <th scope="col">Departure DateTime</th>
                <th scope="col">Arrival DateTime</th>
                <th scope="col">Price</th>
                <th scope="col">Bus ID</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result1)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['startpoint'] . "</td>";
                echo "<td>" . $row['destination'] . "</td>";
                echo "<td>" . $row['departuredt'] . "</td>";
                echo "<td>" . $row['arrivaldt'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['bus_id'] . "</td>"; 
                echo '<td>';
                echo '<a class="btn btn-primary" href="edit_trip.php?id=' . htmlspecialchars($row['id']) . '">Edit</a>';
                echo '<a class="btn btn-danger" href="delete_trip.php?id=' . htmlspecialchars($row['id']) . '" onclick="return confirm(\'Are you sure you want to delete this trip?\')">Delete</a>';
                echo '</td>';
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
       </div></div>



    <?php
// ...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startPoint = strtoupper($_POST["start_point"]);
    $destination = strtoupper($_POST["destination"]);
    $departureDatetime = $_POST["departure_datetime"];
    $arrivalDatetime = $_POST["arrival_datetime"];
    $price = $_POST["price"];
    $busId = $_POST["bus_id"];

        // Validate if trip already exists
    $checkTripQuery = "SELECT * FROM trip WHERE startpoint = '$startPoint' AND destination = '$destination' AND departuredt = '$departureDatetime' AND arrivaldt = '$arrivalDatetime' AND price = '$price' AND bus_id = '$busId'";
    $checkTripResult = mysqli_query($conn, $checkTripQuery);

    if (mysqli_num_rows($checkTripResult) > 0) {
        // Trip ID already exists, display an error message
        echo '<script>alert("Trip ID already exists. Please choose a different ID.")</script>';
    } elseif ($startPoint == $destination) {
        // Start point and destination are the same, display an error message
        echo '<script>alert("Start point and destination cannot be the same.")</script>';
    } elseif (strtotime($departureDatetime) <= time()) {
        // Departure datetime is in the past, display an error message
        echo '<script>alert("Departure datetime cannot be in the past.")</script>';
    } elseif (strtotime($departureDatetime) > strtotime('+2 months')) {
        // Departure datetime is more than two months in the future, display an error message
        echo '<script>alert("Departure datetime cannot be more than two months in the future.")</script>';
    } elseif (strtotime($arrivalDatetime) <= strtotime($departureDatetime)) {
        // Arrival datetime is before or equal to departure datetime, display an error message
        echo '<script>alert("Arrival datetime must be after departure datetime.")</script>';
    } elseif ($price > 2000) {
        // Price is more than 2000 Rs, display an error message
        echo '<script>alert("Price cannot be more than 2000 Rs.")</script>';
    } else {
        // Proceed with adding the trip
        $addTripQuery = "INSERT INTO trip(startpoint,destination,departuredt,arrivaldt,price,bus_id) 
            VALUES('$startPoint','$destination','$departureDatetime','$arrivalDatetime','$price','$busId')";
        $addTripResult = mysqli_query($conn, $addTripQuery);

        if ($addTripResult) {
            // Trip added successfully
            echo '<script>alert("Trip added successfully")</script>';
        } else {
            // Failed to add trip
            echo '<script>alert("Failed to add trip. Please try again.")</script>';
        }
    }
}
?>

    
</body>
</html>