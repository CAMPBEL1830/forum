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
    #headerWrapper {
        position: fixed;
        width: 100%;
        top: 0;
        height: whatever;
        margin-top: -10px;
    }
    .right {
  background-color: lightblue;
  float: left;
  width:80%;
  padding: 10px 15px;
  margin-top: 7px;
}
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
            <a class="navbar-brand" href="home.php">Tech-Talk Forum</a>
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
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
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
                        <a class="nav-link dropdown-toggle" href="dashboard.php" id="navbarDropdown" role="button"
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
    <div>
        <div class="container text-center">
            <h1 class="mt-5 text-dark font-weight-dark">Tech-Talk Forum</h1>

            <form method="post" action="post_ques.php">
                <div class="form-group">
                    <input type="hidden" name="uid" value="$_SESSION['$name']">
                    <textarea name="question" class="form-control" rows="3" required
                        placeholder="Sujet de discussion ?"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Poster une préoccupation</button><br>
            </form>
        </div>
        <hr
            style='height:5px; border:dot; color:blue; background-color:darkblue; width:80%; text-align:center; margin: 0 auto;' />
        <div class="container mt-3">
            <h2>Posts récents</h2>
            <div class="media border p-3">
               
                <div class="media-body">
                    <p>
                        <?php
                        
                        $ques=mysqli_query($conn,"SELECT *  FROM questions order by `date` desc");
                        
                        while($q=mysqli_fetch_array($ques))
                        {
                            $qid=$q['qid'];
                            $date = new DateTime($q['date']);
                            print("<div class='left'>");
                            print ("<h4>".$q['userid']."&nbsp;&nbsp;&nbsp;");
                            print("<small style='color:blue; font-size:0.15in;'><i>Posté le : " . $date->format('d F Y') . "</i></small></h4><br/>");
                            print ("<u>Sujet :</u> <i style='color:darkblue;'>".$q['question']."</i><br/>");
                            print("</div>");
                            $ans=mysqli_query($conn,"SELECT answer,userid FROM answers WHERE qid='$qid'");
                            while($a=mysqli_fetch_row($ans)){
                                print("<div class='right'>");
                                print ("<u>Répondu</u> par <b>".$a[1]."</b> : <span><i>".$a[0]."</i></span>");
                                print("</div>");
                                
                            }
                            
                            print("<div class='right'>");
                            print ("<br/></br><div class='media-body' style='width:80%' >
                                    <form method='post' action='post_answer.php?qid=$qid'>
                                        <textarea class='form-control' name='ans' row='3' placeholder='Donnez votre avis ici sur le sujet' required/></textarea>
                                        <button  class='btn btn-primary' type='submit' value='submit'>Répondre</button>
                                    </form>
                                    <hr style='height:2px; border:dot; color:blue; background-color:darkblue; width:100%; text-align:center; margin: 0 auto;'/></div>");
                                    print("</div>");
                                }

                    ?>

                    </p>
                </div>
            </div>
        </div>


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
    </div>
    <div id="webchat">

	<script src="https://storage.googleapis.com/mrbot-cdn/webchat-latest.js"></script>
	<script>
	  WebChat.default.init({
		selector: "#webchat",
		initPayload: "hi",
		customData: {"language": "en"}, // arbitrary custom data. Stay minimal as this will be added to the socket
		socketUrl: "http://localhost:5005",
		socketPath: "/socket.io/",
		title: "CareerGuru",
		subtitle: "",
		profileAvatar: "https://www.dropbox.com/s/wrn2hm4xgu3z9wn/download.jpg?raw=1",
		embedded : false,
		showCloseButton: true,
        fullScreenMode: false,
        //hideWhenNotConnected: false,
		inputTextFieldHint: "Type a message...",
        connectingText: "Waiting for server...",
     
		openLauncherImage: 'https://www.dropbox.com/s/wrn2hm4xgu3z9wn/download.jpg?raw=1',
		closeLauncherImage:'https://www.dropbox.com/s/wrn2hm4xgu3z9wn/download.jpg?raw=1',
		params: {
      images: {
        dims: {
          width: 200,
          height: 100,
        }
      }}
	  });
	  WebChat.toggle({
	  selector: "#webchat",
	  });
	  </script>
	  </div>
</body>

</html>
