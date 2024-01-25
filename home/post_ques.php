<?php
    include('session.php');
   	
    require('../connect.php');
    $name=$_SESSION['username'];
    $date=$_SESSION['date'];

    if(isset($_POST) & !empty($_POST)){
        $question = mysqli_real_escape_string($conn,$_POST['question']);
        $sql = "insert into questions (userid,question) values ('$name', '$question')";
        $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        if($res){
            echo ("<script>alert('Sujet posté');
    window.location.href='home.php';
    </script>");
        }else{
            
            echo "<script type='text/javascript'>alert('L'envoie de votre sujet a échoué');</script>";
        }
        
    }
?>