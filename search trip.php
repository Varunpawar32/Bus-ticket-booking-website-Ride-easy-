<?php
session_start(); // Resume the existing session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    echo "<script>window.location.href='login form.php'</script>";
    exit();
}

//db connection
$conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");
//$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");

function getBuses($from, $to, $date, $conn) {
    global $conn;

    // Prepare and execute the SQL query
    $startDate = $date . ' 00:00:00';
    $endDate = $date . ' 23:59:59';

    $sql = "SELECT trip.*, bus.number, bus.type, bus.capacity
    FROM trip
    JOIN bus ON trip.bus_id = bus.id
    WHERE startpoint = ? AND destination = ? AND departuredt BETWEEN ? AND ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $from, $to, $startDate, $endDate);
    mysqli_stmt_execute($stmt);

    // Fetch results
    $result = mysqli_stmt_get_result($stmt);
    $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);


    return $searchResults;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $date = $_POST['date'];
    $searchResults = getBuses($from, $to, $date, $conn);

    include("nav.php");

    $searchForm = '
        <div class="container mt-5">
            <form id="searchTripForm1" method="post" action="">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="from">From</label>
                        <input type="text" class="form-control" name="from" id ="from" value="' . $_POST['from'] . '" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="to">To</label>
                        <input type="text" class="form-control" id="to" name="to" value="' . $_POST['to'] . '" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="doj">Date of Journey</label>
                        <input type="date" class="form-control" id="doj" name="date" value="' . $_POST['date'] . '" min="' . date('Y-m-d') . '" max="' . date('Y-m-d', strtotime('+2 months')) . '" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" onclick="searchBuses()">Search Buses</button>
            </form>
        </div><br><br>
    ';
    // Display the search results
    if (empty($searchResults)) {
        echo $searchForm;
        echo '<div class="container mt-4">';
        echo '<div class="alert alert-warning" role="alert">';
        echo '<strong>No buses available!</strong> Unfortunately, there are no buses for the selected route and date.';
        echo '</div>';
        echo '</div>';
    } 
    
    else {
    echo '<div class="container mt-4">';
    foreach ($searchResults as $result) {
        echo $searchForm;


echo '<div class="container mt-2 ">';
echo '<div class="row">';
echo '<div class="col-md-6">';
echo '<h5><i class="bi bi-funnel"></i> Filter By:</h5>';
echo '<form id="filterForm">';
echo '<div class="form-row">';
echo '<div class="form-group col-md-6">';
echo '<label for="filterAC"><i class="bi bi-gear"></i> AC/Non-AC</label>';
echo '<select id="filterAC" class="form-control">';
echo '<option value="all">All</option>';
echo '<option value="AC">AC</option>';
echo '<option value="Non-AC">Non-AC</option>';
echo '</select>';
echo '</div>';
echo '<div class="form-group col-md-6">';
echo '<label for="filterPrice"><i class="bi bi-cash"></i> Price Range</label>';
echo '<select id="filterPrice" class="form-control">';
echo '<option value="all">All</option>';
echo '<option value="0-500">0 - 500</option>';
echo '<option value="501-1000">501 - 1000</option>';
echo '<option value="1001-1500">1001 - 1500</option>';
// Add more options based on your pricing ranges
echo '</select>';
echo '</div>';
echo '</div>';
echo '<button type="button" class="btn btn-primary" onclick="applyFilters()"><i class="bi bi-filter"></i> Apply Filters</button>';
echo '</form>';
echo '</div>';
echo '<div class="col-md-6">';
echo '<h5><i class="bi bi-sort"></i> Sort By:</h5>';
echo '<form id="sortForm">';
echo '<div class="form-row">';
echo '<div class="form-group col-md-6">';
echo '<label for="sortBy"><i class="bi bi-arrow-up-down"></i> Sort By</label>';
echo '<select id="sortBy" class="form-control">';
echo '<option value="departure">Departure Time</option>';
echo '<option value="arrival">Arrival Time</option>';
echo '<option value="price">Price</option>';
// Add more sorting options based on your requirements
echo '</select>';
echo '</div>';
echo '<div class="form-group col-md-6">';
echo '<label for="sortOrder"><i class="bi bi-caret-down-fill"></i> Order</label>';
echo '<select id="sortOrder" class="form-control">';
echo '<option value="asc">Ascending</option>';
echo '<option value="desc">Descending</option>';
echo '</select>';
echo '</div>';
echo '</div>';
echo '<button type="button" class="btn btn-primary" onclick="applySorting()"><i class="bi bi-arrow-right"></i> Apply Sorting</button>';
echo '</form>';
echo '</div>';
echo '</div>';
echo '</div><br><br>';

                
        $trip_Id = $result['id'];
        echo '<div class="card mb-4">
                <div class="card-body text-center">
                    <div class="col">  
                     <div class="row">
                        <div class="col"><p class="card-text"><strong> ' . $result['number'] . '</strong></p></div>
                        <div class="col"><p class="card-text"><strong> ' . $result['startpoint'] . '-' . $result['destination'] . '</strong></p></div>
                        <div class="col"><p class="card-text"><strong> Rs ' . $result['price'] . '</strong></p></div>
                        <div class="col"><p class="card-text"><strong>Available Seats:</strong> ' . "NA/ "   . $result['capacity'] . '</p></div>
                        </div>
                        <div class="row">
                        <div class="col"><p class="card-text"><strong>Departure Time:</strong> ' . $result['departuredt'] . '</p></div>
                        <div class="col"><p class="card-text"><strong>Arrival Time:</strong> ' . $result['arrivaldt'] . '</p></div>
                        <div class="col"><p class="card-text"><strong>type:</strong> ' . $result['type'] . '</p></div>
                        
                        <div class="col"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#seatSelectionModal' . $trip_Id . '">Book</button>
                        </div>
                        
                        </div>
                    </div>
                </div>
            </div>';

        
            echo '<div class="modal fade" id="seatSelectionModal' . $trip_Id . '" tabindex="-1" role="dialog" aria-labelledby="seatSelectionModalLabel" aria-hidden="true">';
            echo '<div class="modal-dialog" role="document">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="seatSelectionModalLabel">Select Number of Seats</h5>';
            echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<form id="seatSelectionForm' . $trip_Id . '" action="booking.php" method="post">';
            echo '<input type="hidden" name="trip_id" value="' . $trip_Id . '">';
            echo '<div class="form-group">';
            echo '<label for="numberOfSeats">Number of Seats:</label>';
            echo '<div class="btn-group btn-group-toggle" data-toggle="buttons">';
            for ($i = 1; $i <= 5; $i++) {
                echo '<label class="btn btn-outline-primary">';
                echo '<input type="radio" name="numberOfSeats" value="' . $i . '" required>' . $i;
                echo '</label>';
            }
            echo '</div>';
            echo '</div>';
            echo '<button type="submit" class="btn btn-primary">Submit</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
            // Assuming $trip_Id is defined before this point
            $_SESSION['trip_id'] = $trip_Id;

            // Set seatSelection based on how you handle seat selection, for example, if it's coming from a form post
            if (isset($_POST['numberOfSeats'])) {
                $_SESSION['seatSelection'] = $_POST['numberOfSeats'];
            }
            

                                
    }
    echo '</div>';}
    include("footer.php");

    exit(); // Stop further execution after displaying results
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Easy Book Ticket</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css">
    <!-- Link to jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Link to Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Link to your custom JavaScript -->
</head>

<body>
    <?php include("nav.php") ?>

    <div class="container mt-5">
    <form id="searchTripForm" method="post" action="">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="from">From</label>
                <input type="text" class="form-control" name="from" id="from" required>
            </div>
            <div class="form-group col-md-4">
                <label for="to">To</label>
                <input type="text" class="form-control" name="to" id="to" required>
            </div>
            <div class="form-group col-md-4">
                <label for="doj">Date of Journey</label>
                <input type="date" class="form-control" name="date" id="doj" min="<?= date('Y-m-d'); ?>"
                    max="<?= date('Y-m-d', strtotime('+2 months')); ?>" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search Buses</button>
    </form>
</div>
<?php include("footer.php") ?>
</body>

</html>
