<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login form.php'</script>";
    exit();
}

$trip_Id = $_SESSION['trip_id'] ?? null;


   //db connection
   $conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");
   //$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");

// Check if trip_Id is set
if ($trip_Id) {
    // Fetch trip details from the database
    $query = "SELECT * FROM trip WHERE id = $trip_Id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $tripDetails = mysqli_fetch_assoc($result);

        // Fetch corresponding bus details
        $busId = $tripDetails['bus_id'];
        $busQuery = "SELECT * FROM bus WHERE id = $busId";
        $busResult = mysqli_query($conn, $busQuery);

        if ($busResult) {
            $busDetails = mysqli_fetch_assoc($busResult);
        } else {
            echo "Error fetching bus details: " . mysqli_error($conn);
        }
    } else {
        echo "Error fetching trip details: " . mysqli_error($conn);
    }
}

// Retrieve selected seat numbers from the session
$selectedSeats = isset($_POST['selectedSeats']) ? $_POST['selectedSeats'] : '';
$selectedSeatsArray = explode(',', $selectedSeats);


// Count the number of selected seats
$noofSeats = count($selectedSeatsArray);

// Store the number of seats in the session
$_SESSION['noofseats'] = $noofSeats;

$noofSeats = isset($_SESSION['noofseats']) ? $_SESSION['noofseats'] : 0;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride-Easy Ticket Confirmation</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        .card {
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .terms-modal {
            text-align: left;
        }
    </style>
</head>

<body>
    <?php include('nav.php') ?>

    <div class="container">
        <div class="card">
            <h2 class="mb-4">Ticket Confirmation</h2>

            <!-- Trip Details -->
            <div class="card">
                <h4 class="card-header">Trip Details</h4>
                <div class="card-body">
                    <p><strong>Start Point:</strong> <?= $tripDetails['startpoint'] ?></p>
                    <p><strong>Destination:</strong> <?= $tripDetails['destination'] ?></p>
                    <p><strong>Departure:</strong> <?= $tripDetails['departuredt'] ?></p>
                </div>
            </div>

            <!-- Bus Details -->
            <div class="card mt-4">
                <h4 class="card-header">Bus Details</h4>
                <div class="card-body">
                    <p><strong>Bus Number:</strong> <?= $busDetails['number'] ?></p>
                    <p><strong>Bus Type:</strong> <?= $busDetails['type'] ?></p>
                </div>
            </div>

            <!-- Seat Details -->
            <div class="card mt-4">
                <h4 class="card-header">Seat Details</h4>
                <div class="card-body">
                    <p><strong>Number of Seats:</strong> <?= $noofSeats ?></p>
                    <p><strong>Selected Seats:</strong> <?= implode(', ', $selectedSeatsArray) ?></p>
                </div>
            </div>

            <!-- Terms and Conditions Modal Trigger Button -->
            <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#termsModal">
                Confirm Ticket
            </button>

            <!-- Terms and Conditions Modal -->
            <div class="modal fade terms-modal" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Your terms and conditions content goes here...</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="proceedToPaymentBtn" disabled>Proceed to
                                Payment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Enable the 'Proceed to Payment' button when terms are accepted -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#termsModal').on('change', 'input[type="checkbox"]', function () {
                $('#proceedToPaymentBtn').prop('disabled', !this.checked);
            });
        });
    </script>
</body>

</html>
