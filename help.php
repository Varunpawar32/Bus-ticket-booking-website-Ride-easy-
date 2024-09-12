<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Easy Help</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Link to your custom CSS -->
    <link rel="stylesheet" href="search trip.css">
    <!-- Link to Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: rgb(215, 222, 239);
            text-decoration: solid;
            transition: cubic-bezier(0.075, 0.82, 0.165, 1);
            text-decoration-color: black;
            margin-top: 50px;
        }

        .help-content {
            padding: 50px 20px;
            font-size: 20px;
        }

        footer {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <?php include("nav.php"); ?>

    <h2 ><b>How Ride Easy Help</b></h2>

    <div class="help-content">
        <h2>Frequently Asked Questions (FAQs)</h2>
        <p>1. <strong>How to book a ticket?</strong><br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, odio vel luctus luctus, erat
            libero euismod odio.</p>

        <p>2. <strong>How to view booked tickets?</strong><br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, odio vel luctus luctus, erat
            libero euismod odio.</p>

        <p>3. <strong>How to update my profile?</strong><br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, odio vel luctus luctus, erat
            libero euismod odio.</p>

        <!-- Add more FAQs as needed -->

        <h2>Contact Us</h2>
        <p>If you have further questions, please contact our support team at <a
                href="mailto:support@rideeasy.com">support@rideeasy.com</a>.</p>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>
