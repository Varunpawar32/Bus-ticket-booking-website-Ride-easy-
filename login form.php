<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data
    $username = $_POST['login'];
    $password = $_POST['pass'];

    // Database connection
$conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");
//$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");

    // Validation
    $query = "SELECT * FROM user WHERE mobile_no = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // Fetch user data
        $row = $result->fetch_assoc();
        
        // Verify password
        if ($password === $row['password']) { // Change this line to compare plain text passwords
            // Password is correct
            $_SESSION['user_id'] = $username;
            echo "<script>window.location.href='home.php'</script>";
            exit();
        } else {
            // Incorrect password
            $error_message = "Incorrect password";
        }
    } else {
        // User not found
        $error_message = "User not found";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bt.css">
    <title>Login</title>
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h2>RIDE EASY LOGIN</h2>
        <form id="login form" action="" method="post">
            <table>
                <tr><td><input type="text" name="login" id="user" size="40px" title="enter your details" placeholder="Enter your phone number" required></td></tr><br>
                <tr><td><input type="password" name="pass" id="fn" title="enter your password" placeholder="Enter your password" required></td><br></tr>
                <tr><td><a href="forgot password.php">Forgot password ?</a></td></tr>
            </table>
            <button type="submit" value="submit">Submit</button><button type="reset" value="reset">Reset</button>
            <br>
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <p>If not an existing user <a href="registration form.html">create a new account</a></p>
        </form>
    </div>
</body>
</html>
