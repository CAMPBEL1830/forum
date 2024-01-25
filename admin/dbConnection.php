<?php
$servername = "localhost";
$username="root";
$password="";
$dbname="confer";

$conn=mysqli_connect($servername,$username,$password,$dbname);
if($conn)
{
	echo'';
}
else
{
	die("Connexion échouée car ".mysqli_connect_error());
}

?>