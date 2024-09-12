<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Ride Easy</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Link to your custom CSS -->
    <style>
        /* Add any additional styles here */
        body {
            background-color: #f4f4f4;
        }

        .jumbotron {
            background-color:black;
            color: #fff;
            padding: 50px;
        }

        h1 {
            font-size: 36px;
            color: #000;
        }

        p {
            font-size: 18px;
        }
    </style>
</head>

<body>

    <?php include("nav.php") ?>

    <div class="jumbotron text-center">
        <h1 class="display-4">About Us</h1>
        <p class="lead">Ride Easy - Your Convenient Travel Partner</p>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6">
                <h2>Our Mission</h2>
                <p>We are committed to providing safe, reliable, and comfortable transportation for our passengers. Your journey with us is our top priority.</p>
            </div>
            <div class="col-lg-6">
                <h2>Our Vision</h2>
                <p>To become the leading platform for hassle-free travel, offering a seamless experience from booking to reaching your destination.</p>
            </div>
        </div>
    </div>

    <!-- Add more sections as needed -->

    <?php include("footer.php") ?>

    <!-- Link to Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
