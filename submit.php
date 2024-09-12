<?php

$firstname = $_POST["fname"];
$middlename = $_POST["mname"];
$lastname = $_POST["lname"];
$dob = $_POST["dob"];
$mobilenumber = $_POST["mno"];
$emailid = $_POST["eid"];
$password = $_POST["pass"];

$conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");
//$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");
$sql = "INSERT INTO user (First_name, Middle_name, Last_name, dob, mobile_no, email_id, password) 
        VALUES ('{$firstname}', '{$middlename}', '{$lastname}', '{$dob}', '{$mobilenumber}', '{$emailid}', '{$hashedPassword}')";
$result = mysqli_query($conn, $sql) or die("Registration failed. Please try again.");

if ($result) {
    // Registration successful
    echo "<script>window.location.href='login form.php'</script>";
    exit();
} else {
    // Registration failed
    exit();
}

?> 

