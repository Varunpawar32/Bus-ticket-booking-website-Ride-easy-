<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>forgot password</title>
    link rel="stylesheet"  href="bt.css">
</head>
<body>
    
    <div class="registration-container">
        <h2>Recover your account</h2>
        <form id="forgotpass" action="" method="post">
            <input type="email" name="email" placeholder="Enter your registered email address" required><br>
            <span>we will send you mail for creating new password</span>
            <button type="submit" value="submit" >send mail</button>
        </form>
    </div>
</body>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST")

{
    $email = $_POST['email'] ;

    $conn = mysqli_connect("localhost","root","","ride_easy_database") or die("connection failed");
   //$conn = mysqli_connect("localhost","id21615079_varunpawar32","Suhas@2003","id21615079_ride_easy") or die("connection failed");
   
   //validate
   $query = "SELECT * FROM USER WHERE email_id = '$email' " ;
   $query1 = "SELECT * FROM USER ";
   $result = mysqli_query($conn,$query);
   $result1 = mysqli_query($conn,$query1); 

   if ($result-> num_rows == 1) {
    $userdata = mysqli_fetch_array($result1);
    $firstname = $userdata['First_name'];
    $lastname = $userdata['Last_name'];
    $mobileno = $userdata['mobile_no'];
    
    $subject = "PASSWORD RESET";
    $body = "Hii, $firstname $lastname Click here to reset your password http://localhost/ride%20easy%20website/loginform.php?token=$mobileno";
    $sender_email = "From: varunsuhaspawarvsp32@gmail.com";
    
        if(mail($email,$subject,$body,$sender_email))
         {

        echo"<script>alert('email sent sucessfully')</script>";
        header('location:loginform.php');
        }
         }
    else {
    echo"<script>alert('no email match')</script>";
   }

}
?>
</html>