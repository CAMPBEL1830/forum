<?php
  session_start();
  require('../connect.php');
  $password=$_POST['password'];
  $email=$_SESSION['email'];

  mysqli_select_db($conn,"confer");

  $update2="update `users` SET `password` = '$password' where `email`='$email'";
  $Data=mysqli_query($conn,"$update2")or die("Pas de mise à jour".mysql_error());
if(!$Data){
    echo ("<script>alert('Error in Updated');</script>").mysql_error();
}
else{
    echo ("<script>alert('Le mot de passe est changé');
    window.location.href='setting.php';
    </script>");
}
mysqli_close($conn);
?>