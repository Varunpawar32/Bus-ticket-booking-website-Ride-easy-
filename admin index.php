<?php
// Start or resume a session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['admin_id'])) {
    echo"<script> window.location.href='admin login.php'</script>";
    // Redirect to the login page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride-easy admin page</title>
    <link rel="stylesheet" href="admin pages.css">


    
</head>
<body>
    <?php include ("admin nav.php")?>
    <?php

    //db connection
    $conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");
    //$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");

    //query for userstotal
    $query = "SELECT * FROM user";
    $result =  $conn->query($query);
    $count = mysqli_num_rows($result);
 
    //query for bustotal
    $query = "SELECT * FROM bus";
    $result =  $conn->query($query);
    $count1 = mysqli_num_rows($result);

    //query triptotal
    $query1 = "SELECT * FROM trip";
    $result1 =  $conn->query($query1);
    $count2 = mysqli_num_rows($result1);


    ?>

<p><span>currently Total no of registered users: <label id="userstotal" ><?php echo $count ;?></label> users</span></p>
<p><span>currently Total no of buses: <label id="busestotal" ><?php echo $count1 ;?></label> buses</span></p>
<p><span>currently Total no of active trips: <label id="tripstotal" ><?php echo $count2 ;?></label> trips</span></p>

    <div class="circle-container">
        <a href="bus management.php"><div class="circle"><span>bus management</span></div></a>
        <a href="trip management.php"><div class="circle"><span>trip management</span></div></a>
        <a href="booking updates.php"><div class="circle"><span>booking updates</span></div></a>
    </div>
</body>

</html>
