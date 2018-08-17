<?php
session_start();
require('include/config.php');

if (isset($_REQUEST['email']) && !empty($_REQUEST['email']) && isset($_REQUEST['pswd']) && !empty($_REQUEST['pswd']) && isset($_REQUEST['submit'])) {

  // Defining your login details into variables
  $email=$_POST['email'];
  $password=$_POST['pswd'];
  //$encrypted_mypassword=md5($mypassword); //MD5 Hash for security
  // MySQL injection protections
  $username = stripslashes($email);
  $password = stripslashes($password);
  $myusername = mysqli_real_escape_string($con,$username);
  $mypassword = mysqli_real_escape_string($con,$password);
  $sql="SELECT * FROM login_data WHERE email='$myusername' and password='$mypassword'" or die(mysqli_error());
  $user_exist=mysqli_query($con,$sql) or die(mysqli_error());
  // Checking table row
  $row_count=mysqli_num_rows($user_exist);
  // If username and password is a match, the count will be 1
  if($row_count==1){
    // If everything checks out, you will now be forwarded to voter.php
    $user = mysqli_fetch_assoc($user_exist);
    $_SESSION['id'] = $user['id'];
    header("location:dashboard.php");
  }
  //If the username or password is wrong, you will receive this message below.
  else {
    echo "Wrong Username or Password";
  }
}
?>