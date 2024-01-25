<?php 
include('index.php');
include('connect.php');

$username=$_POST['username'];
$name=$_POST['name'];
$password=$_POST['password'];
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$gender=$_POST['gender'];


mysqli_select_db($conn,"confer");
$data="insert into users(userid,name,password,email,mobile,gender) values('$username','$name','$password','$email','$mobile','$gender')";
$insertData=mysqli_query($conn,"$data");
if(!$insertData){
    echo ("<script>alert('Enregistrement échoué');</script>").mysqli_error();
}
else{
    mysqli_query($conn,"insert into user_notifications (notification,userid) values ('Bienvenue sur Tech-Talk Forum','$username')");
    mysqli_query($conn,"insert into admin_notifications (notification) values ('Utilisateur <b>$username</b> a rejoint Tech-Talk Forum')");
    echo ("<script>alert('Enregistrement effectué');
    window.location.href='index.php';
    </script>");
}
?>
