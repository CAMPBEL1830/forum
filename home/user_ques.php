<?php
    include('session.php');
   	
    require('../connect.php');
    $name=$_SESSION['username'];
    $date=$_SESSION['date'];
?>
<html>

<head>
    <title>Tech-Talk Forum</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../jquery/jquery3.2.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <style>
    .left {
  background-color: wheat;
  float: left;
  width:80%;
  padding: 10px 15px;
  margin-top: 7px;
}
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="headerWrapper">
        <div class="container">
            <a class="navbar-brand" href="home.php"> Tech-Talk Forum</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-left">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span>Historiques</span>
                            <br>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="user_ques.php">Sujets</a>
                            <a class="dropdown-item" href="user_answer.php">Réponses</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_notifications.php">
                        <?php
                            $q="SELECT count(*) FROM user_notifications where userid='".$_SESSION['username']."'";
                            $d=mysqli_query($conn,$q);
                            $notif_count=mysqli_fetch_row($d);
                            ?>
                            Notifications<b><i><span style='background-color:grey;color:white;'><?php echo" $notif_count[0]";?></span></i></b>

                        </a>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="../img_avatar.png" alt="logo image"
                                style="width:20px;height:18px;"><?php echo $full_name; ?>
                            <br>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="dashboard.php">Profil</a>
                            <a class="dropdown-item" href="setting.php">Paramètres</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Déconnexion</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <p></p>
    <div class="container mt-3">
        <h2>Vos sujets</h2>
        <div class="media border p-3">
            <!--<img src="img_avatar3.png" alt="John Doe" class="mr-3 mt-3 rounded-circle" style="width:60px;">-->
            <div class="media-body">
                 <p>
                    <?php
                        
                        $ques=mysqli_query($conn,"SELECT `question`,`date`  FROM questions where userid='".$_SESSION['username']."' order by `date` desc");
                        
                        while($q=mysqli_fetch_array($ques))
                        {                           
                            $date = new DateTime($q['date']);
                            print ("<div class='left'><small style='color:blue; font-size:0.13in;'><i>Posté le : " . $date->format('d F Y') . "</i></small></h4><br/>");
                            print ("Sujet: <i>".$q['question']."</i><br/><hr/></div>");  
                        }

                    ?>

                </p>
            </div>
        </div>
    </div>
    <br><br><br><br><br>
    <footer class="page-footer font-small teal pt-6 navbar-white bg-dark text-white" style="width:100%;">
        <div class="container-lebal text-center text-md-center" style='color:white;wieght:10%;   font-size:0.13in;'>
            <div class="row">
                <div class="col-md-6 mt-md-0 mt-6 text-left " style="margin-left:3%;" >
                    <h5 class=" font-weight-bold">Contactez nous ici</h5>
                    <p><a href="mailto:esatic.mbds@gmail.com"><strong style="color: white;">Email de MBDS: esatic.mbds@gmail.com</strong> </a><br />
                        <br> ESATIC : MBDS 2, 2023-2024</p>
                </div>
                <hr class="clearfix w-60 d-md-none pb-2">
                <div class="col-md-5 mb-md-0 mb-6 text-right" style="margin-right:2%;">
                    <h5 class=" font-weight-bold">Apropos de nous</h5>
                        <p>Cette application fait office d'un projet de classe dans le cadre de l'apprentissage de la méthode DevOps. C'est le lieu pour nous de mettre en pratique les procédés d'automatisation de tests, les CI/CD.</p>
                </div>
            </div>
            <div class="footer-copyright text-center py-3">© 2023 Copyright:
                <a href="https://www.yes-ivoire.com" target="_blank">Tous droits réservés</a>  @ESATIC-MBDS 2023-2024
            </div>
        </div>
    </footer>
</body>

</html>