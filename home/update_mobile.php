<?php
  session_start();
  require('../connect.php');

  $mobile=$_POST['mobile'];
  $email=$_SESSION['email'];

  mysqli_select_db($conn,"confer");

  $update2="update `users` SET `mobile` = '$mobile' where `email`='$email'";
  $Data=mysqli_query($conn,"$update2")or die("Pas de mise à jour ".mysql_error());
if(!$Data){
    echo ("<script>alert('Erreur de mise à jour');</script>").mysql_error();
}
else{
    echo ("<script>alert('Numéro de téléphone mis à jour');
    window.location.href='setting.php';
    </script>");
}
mysqli_close($conn);
?>