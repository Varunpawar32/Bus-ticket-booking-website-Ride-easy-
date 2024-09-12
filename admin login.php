<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bt.css">
    <title>admin login</title>
</head>
<body>
   <div class="registration-container">
    <h2>RIDE EASY admin LOGIN</h2>
    <form id="login form" action="" method="post">
        <table>
            <tr><td><input type="text" name="login" id="user" size="40px" title="enter your details" placeholder="Enter your admin id" required></td></tr><br>
            <tr><td><input type="password" name="pass" id="fn" title="enter your password" placeholder="Enter your password" required></td><br></tr>
        </table>
        <button type="submit" value="submit">submit</button><button type="reset" value="reset">reset</button>
        <br>
        <p>If not a admin <a href="loginform.php"> login as a user</a></p>
    </form>
    </div>
</body>
<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //retrive data
    $username = $_POST['login'];
    $password = $_POST['pass'];

    //db connection
    $conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");
    //$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");

    //validation
    $query = "SELECT * FROM admin WHERE id = '$username' AND password = '$password'";

    $result = $conn->query($query);

    if($result->num_rows == 1 ){
        //login sucessful
        $_SESSION['admin_id'] = $username; // Set the session variable
        header("Location: admin index.php");
        
        //echo"<script> window.location.href='loginform.php'</script>";
        echo'<script> alert("login sucessfull")</script>';

        exit();
    }
    else{
        //login failed
        echo'<script> alert("incorrect mobile number or password")</script>';
        exit();
    }

    $conn->close();

}
?>
</html>