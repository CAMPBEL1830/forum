<?php
    include('session.php');
   	
    require('../connect.php');
    $name=$_SESSION['username'];
    $date=$_SESSION['date'];

    if(isset($_POST) & !empty($_POST)){
        $answer = mysqli_real_escape_string($_POST['ans']);
        $qid = $_GET['qid'];
        
        $sql = "insert into answers (userid,answer,qid) values ('$name', '$answer','$qid')";
        $res = mysqli_query($sql) or die(mysql_error($conn));
        if($res){
            echo "<script type='text/javascript'>alert('Votre réponse a ete envoyée');</script>";
            header("Location:home.php");
        }else{
            
            echo "<script type='text/javascript'>alert('L'envoie de votre réponse a échoué');</script>";
        }
    
    }
?>