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
    <style>
        .navbar {
            background-color: #3498db;
            justify-content: flex-end;
            padding-bottom: 1px;
        }

        .navbar-sub {
            display: none;
            position: absolute;
            background-color: #3498db;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            list-style: none;
            padding: 5px;
            left: 0;
            border-top: 1px solid #ecf0f1;
        }

        .navbar-sub li {
            display: block;
            margin: 0;
            padding: 5px;
            border-bottom: 1px solid #ecf0f1;
        }

        .navbar-sub a {
            padding: 10px;
            display: block;
            color: #fff;
            font-weight: bold;
            font-size: 14px;
            text-decoration: none;
        }

        .navbar li {
            position: absolute;
            border-bottom: 1px solid #ecf0f1;
            border-top: 1px solid #ecf0f1;
            float :left;
        }

        .navbar li:hover .navbar-sub {
            display: block;
        }

        .navbar-sub li:hover {
            background-color: #2c3e50;
        }

        .active-page {
            background-color: #2c3e50;
        }
    </style>

    <!-- Link to Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>    
    <h1 class="text-center text-dark"><b>Ride easy book ticket</b></h1>

    <header>
        <nav class="navbar navbar-expand text-center">
            <ul class="navbar-nav list-unstyled">
                <li class="nav-item">
                    <a href="home.php" class="nav-link text-white">HOME</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-white" id="profileDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        My Profile
                    </a>
                    <div class="dropdown-menu navbar-sub" aria-labelledby="profileDropdown">
                        <a href="mydetails.php" class="dropdown-item">My Details</a>
                        <a href="changepassword.php" class="dropdown-item">Change Password</a>
                        <a href="updateemail.php" class="dropdown-item">Update Email</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-white" id="ticketDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Book Ticket
                    </a>
                    <div class="dropdown-menu navbar-sub" aria-labelledby="ticketDropdown">
                        <a href="search trip.php" class="dropdown-item">Search Bus</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-white" id="viewTicketDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        View Booked Ticket
                    </a>
                    <div class="dropdown-menu navbar-sub" aria-labelledby="viewTicketDropdown">
                        <a href="alltickets.php" class="dropdown-item">All Tickets</a>
                        <a href="activetickets.php" class="dropdown-item">Active Tickets</a>
                        <a href="expiredtickets.php" class="dropdown-item">Expired Tickets</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="about us.php" class="nav-link text-white">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="help.php" class="nav-link text-white">Help</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-white">Logout</a>
                </li>
            </ul>
        </nav>
    </header>



</body>

</html>
