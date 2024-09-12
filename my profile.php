<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login form.php");
    exit();
}

include("nav.php"); // Assuming you have a navigation bar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Your custom CSS file -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">My Profile</h2>
    <div class="row">
        <div class="col-md-6">
            <?php

            
            //db connection
            $conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");
            //$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");
            // Fetch user data from the database
            $userId = $_SESSION['user_id'];
            $query = "SELECT * FROM user WHERE mobile_no = $userId ";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $userData = mysqli_fetch_assoc($result);
                ?>
                <table class="table">
                    <tr>
                        <th>Full Name:</th>
                        <td><?php echo $userData['First_name'] . ' ' . $userData['Middle_name'] . ' ' . $userData['Last_name']; ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo $userData['email_id']; ?></td>
                    </tr>
                    <tr>
                        <th>Mobile Number:</th>
                        <td><?php echo $userData['mobile_no']; ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth:</th>
                        <td><?php echo $userData['dob']; ?></td>
                    </tr>
                </table>
            <?php } ?>
        </div>
        <div class="col-md-6">
            <!-- Form for changing password -->
            <form id="change-password-form">
                <h4>Change Password</h4>
                <div class="form-group">
                    <label for="current-password">Current Password:</label>
                    <input type="password" class="form-control" id="current-password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new-password">New Password:</label>
                    <input type="password" class="form-control" id="new-password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary">Change Password</button>
            </form>

            <!-- Form for updating email -->
            <form id="update-email-form" class="mt-4">
                <h4>Update Email</h4>
                <div class="form-group">
                    <label for="new-email">New Email:</label>
                    <input type="email" class="form-control" id="new-email" name="new_email" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Email</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS scripts (Popper.js and Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Your custom scripts or additional libraries -->

</body>
</html>

<?php
// Include your footer file
include("footer.php");
?>
