<?php
  session_start();
  include("../connect.php");

  $username=$_POST['username'];
 
  $email=$_POST['email'];

  mysql_select_db("confer");

  $update2="UPDATE `users` SET username = '$username' where email='$email'";
  $Data=mysql_query("$update2")or die("Pas de mise à jour ".mysql_error());
if(!$Data){
    echo ("<script>alert('Erreur dans la mise à jour');</script>").mysql_error();
}
else{
    echo ("<script>alert('Enregistrement effectué');
    window.location.href='setting.php';
    </script>");
}
mysql_close($conn);
?>