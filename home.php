<?php
session_start(); // Resume the existing session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    echo"<script> window.location.href='login form.php'</script>";
    exit();
}

// Rest of your page content goes here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Easy Book Ticket</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Link to your custom CSS -->
    <link rel="stylesheet" href="search trip.css">

    <!-- Link to Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 
</head>
<body>
<?php include ("nav.php")?>

<body>

        <!-- Sliding Image Carousel -->
    <div id="imageCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="bus1.jpeg"  height="400" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="bus2.jpeg" height="400" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="multiplebus.jpeg" height="400" class="d-block w-100 " alt="...">
            </div>
            <!-- Add more carousel items as needed -->
        </div>
        <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
   

    <div class="container mt-5">
    <form id="searchTripForm" method="post" action="search trip.php">
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

   

</body>

</html>

</body><body>
   
<?php include ("footer.php")?>
   
</body>
</html>
