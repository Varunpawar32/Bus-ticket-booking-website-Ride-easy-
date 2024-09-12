<?php
session_start();

// Include necessary files and initialize your database connection here

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    echo "<script>window.location.href='login form.php'</script>";
    exit();
}

$trip_Id = $_SESSION['trip_id'] ?? null;
$noofSeats = isset($_POST['numberOfSeats']) ? [(int)$_POST['numberOfSeats']] : [1]; // Default to 1 if not set
$_SESSION['noofseats'] = $noofSeats;
// db connection
$conn = mysqli_connect("localhost", "root", "", "ride_easy_database") or die("connection failed");

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

            // Now $tripDetails contains details of the trip, and $busDetails contains details of the bus
        } else {
            echo "Error fetching bus details: " . mysqli_error($conn);
        }
    } else {
        echo "Error fetching trip details: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ride easy ticket booking</title>
    <!-- Include Bootstrap and other necessary CSS -->
    <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
    <style>
        /* Add your custom styles for seat display here */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .bus-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .bus-card {
            position: relative;
            width: 290px; /* Adjust the width as needed */
            height: auto; /* Adjust the height as needed */
            background-color: #f5f5f5; /* Bus color */
            border-radius: 10px; /* Rounded corners for the bus shape */
            overflow: hidden;
            margin: 50px auto; /* Center the bus card */
        }

            
    .driver-img {
        position: absolute;
        bottom: 5px;
        left: 08px; /* Adjust the left position as needed */
        width: 70px;
        height: 70px;
    }

    .door-img {
        position: absolute;
        bottom: 80px;
        right: 5px; /* Adjust the right position as needed */
        width: 40px;
        height: 40px;
    }

    .bus-body {
        padding: 10px;
        display: flex;
        flex-wrap: wrap;
        position: relative; /* Add position relative to contain absolute positioned images */
    }

    .driver-line {
        position: absolute;
        bottom: 90px; /* Adjust the bottom position to place the line above the driver */
        left: 5px; /* Adjust the left position as needed */
        width: 50%; /* Adjust the width as needed */
        height: 2px; /* Adjust the height of the line */
        background-color: black; /* Adjust the color of the line */
    }


        .seat {
            width: 40px;
            height: 40px;
            background-image: url('white.png');
            background-size: cover;
            margin: 5px;
            cursor: pointer;
            position: relative;
        }

        .seat-number {
            font-size: 09px;
            position: absolute;
            top: 60%;
            left: 50%;
            font-weight: bolder;
            transform: translate(-50%, -50%);
            color: blue; /* Change the color as needed */
        }

        .gap {
            width: 50px;
        }

        .new-line {
            flex-basis: 100%;
            height: 0;

            clear: both;
        }

        /* Add your custom styles for seat display here */
        .selected-seat {
            width: 40px;
            height: 40px;
            background-image: url('white.png'); /* or your desired background for selected seats */
            background-size: cover;
            background-color:aqua;
            margin: 5px;
            cursor: pointer;
            position: relative;
        }

        .selected-seat .seat-number {
            position: absolute;
            top: 60%;
            left: 50%;
            font-weight: bolder;
            font-size: 09px; /* Adjust the font size as needed */
            color: black; /* Text color for seat number on selected seat */
        }
    </style>
</head>

<body>
    <!-- Include your navigation bar here -->
   <?php include('nav.php')?>
    <div class="container mt-4">
        <h2>Seat Selection - <?= $busDetails['number'] ?></h2>
        <p>Trip Details: <?= $tripDetails['startpoint'] ?> to <?= $tripDetails['destination'] ?> | Departure: <?= $tripDetails['departuredt'] ?> | Bus Type: <?= $busDetails['type'] ?></p>

        <!-- Allow users to change the number of seats -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Listen for changes in the dropdown selection
        $('#numberOfSeats').change(function () {
            // Automatically submit the form when the selection changes
            $('#changeSeatsForm').submit();
        });
    });
</script>

<form id="changeSeatsForm" method="post" >
    <div class="form-group">
        <label for="numberOfSeats">Change Number of Seats:</label>
        <select id="numberOfSeats" class="form-control" name="numberofSeats">
            <?php
            // Display options based on the user's selected number of seats
            for ($i = 1; $i <= 5; $i++) {
                $selectedOption = (in_array($i, $noofSeats)) ? 'selected' : '';
                echo '<option value="' . $i . '" ' . $selectedOption . '>' . $i . '</option>';
            }
            ?>
        </select>
    </div>
</form>


        <?php
// Function to generate seat labels (1, 2, 3, ...)
function getSeatLabel($number) {
    return $number;
}
?>

        <div class="bus-container">
            <div class="bus-card">
                
               <img src="driver.png" alt="Driver" class="driver-img">
               <div class="driver-line"></div>
                <!-- Bus body containing seats -->
                <div class="bus-body">
                    <?php
                    $totalSeats = $busDetails['capacity'];

                    // Display the first line with 5 seats and seat numbers
                    for ($seatNumber = 1; $seatNumber <= 5; $seatNumber++) {
                        echo '<div class="seat" data-seat-number="' . getSeatLabel($seatNumber) . '">';
                        echo '<span class="seat-number">' . getSeatLabel($seatNumber) . '</span>';
                        echo '</div>';
                    }

                    // Insert a gap and a new line after the first line
                    echo '<div class="gap"></div>';
                    echo '<div class="new-line"></div>';

                    // Display the remaining seats in the specified pattern with seat numbers
                    for ($seatNumber = 6; $seatNumber <= $totalSeats; $seatNumber++) {
                        echo '<div class="seat" data-seat-number="' . getSeatLabel($seatNumber) . '">';
                        echo '<span class="seat-number">' . getSeatLabel($seatNumber) . '</span>';
                        echo '</div>';

                        // Insert a gap after every second seat
                        if (($seatNumber - 5) % 2 == 0) {
                            echo '<div class="gap"></div>';
                        }

                        // Insert a new line after every fourth seat
                        if (($seatNumber - 5) % 4 == 0) {
                            echo '<div class="new-line"></div>';
                        }
                    }echo'<br><br><br><br><br><br><br><br>';
                    ?>
                    
                </div>
                    
                <img src="door.png" alt="Door" class="door-img">
            </div>           
       </div>
         <form method="post" action="confirmation.php">
            <input type="hidden" name="selectedSeats" id="selectedSeats" value="">
            <button type="submit">Submit</button>
            </form>
    </div>
    
                    
   <?php include("footer.php");?>

    <!-- Include Bootstrap and other necessary scripts -->
    <script src="path/to/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
    var maxSeats = <?= $noofSeats[0] ?>; // Maximum number of seats allowed
    var seats = document.querySelectorAll('.seat');

    seats.forEach(function (seat) {
        seat.addEventListener('click', function () {
            // Check if the seat is already selected
            var isSelected = seat.classList.contains('selected-seat');

            // Check if selecting the seat is allowed
            if (!isSelected && getSelectedSeatsCount() >= maxSeats) {
                alert('You can only select up to ' + maxSeats + ' seats.');
                return;
            }

            // Toggle selected class
            seat.classList.toggle('selected-seat');

            // Get seat number
            var seatNumber = seat.getAttribute('data-seat-number');

            // Check if seat is selected and update the hidden input field value
            if (seat.classList.contains('selected-seat')) {
                // Add the selected seat number to the hidden input value
                addToSelectedSeats(seatNumber);
            } else {
                // Remove the selected seat number from the hidden input value
                removeFromSelectedSeats(seatNumber);
            }
        });
    });

    // Function to get the count of selected seats
    function getSelectedSeatsCount() {
        var selectedSeats = document.querySelectorAll('.selected-seat');
        return selectedSeats.length;
    }

    // Function to add selected seat to the hidden input value
    function addToSelectedSeats(seatNumber) {
        var selectedSeatsInput = document.getElementById('selectedSeats');
        var currentSelectedSeats = selectedSeatsInput.value.split(',');

        // Add the selected seat number to the array
        currentSelectedSeats.push(seatNumber);

        // Update the hidden input value
        selectedSeatsInput.value = currentSelectedSeats.join(',');
    }

    // Function to remove selected seat from the hidden input value
    function removeFromSelectedSeats(seatNumber) {
        var selectedSeatsInput = document.getElementById('selectedSeats');
        var currentSelectedSeats = selectedSeatsInput.value.split(',');

        // Remove the selected seat number from the array
        var index = currentSelectedSeats.indexOf(seatNumber);
        if (index !== -1) {
            currentSelectedSeats.splice(index, 1);
        }

        // Update the hidden input value
        selectedSeatsInput.value = currentSelectedSeats.join(',');
    }
});


    </script>
</body>

</html>
