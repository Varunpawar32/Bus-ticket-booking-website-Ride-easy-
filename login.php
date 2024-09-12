<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //retrive data
    $username = $_POST['login'];
    $password = $_POST['pass'];

    //db connection
    $conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");

    //validation
    $query = "SELECT * FROM user WHERE mobile_no = '$username' AND password = '$password'";

    $result = $conn->query($query);

    if($result->num_rows == 1 ){
        //login sucessful
        header("Location: search trip.html");
        exit();
    }
    else{
        //login failed
        echo'<script>alert("invalid password or mobile no")</script>';
        header("Location: login form.html");
        exit();
    }

    $conn->close();

}
?>