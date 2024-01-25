<?php
session_start();
include("dbConnection.php");
$user=$_SESSION['uname'];
if($user==true)
{}
else
{
  header('location:index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
</head>
<body>
    <?php
    include("header.html");
    
    ?>
    <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
  

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
     <li class="nav-item active">
        <a class="nav-link" href="admin.php?q=1">
          <i class="fa fa-home"></i>
          Admin
          <span class="sr-only">(current)</span>
          </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="admin.php?q=2">
          <i class="fa fa-envelope-o">
          </i>
          Utilisateurs
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin.php?q=3">
          <i class="fa fa-envelope-o">
            
          </i>
          Sujets
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin.php?q=4">
          <i class="fa fa-envelope-o">
            
          </i>
          Réponses
        </a>
      </li>
     <li class="nav-item">
        <a class="nav-link" href="generate_pdf.php" target='_blank'>
          <i class="fa fa-envelope-o">
            
          </i>
          Rapport
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin.php?q=6">
          <i class="fa fa-envelope-o">
          
          </i>
          <?php
          $q="SELECT count(*) FROM admin_notifications";
          $d=mysqli_query($conn,$q);
          $notif_count=mysqli_fetch_row($d);
          ?>
          Notifications<b><i><span style='background-color:grey;color:white;'><?php echo" $notif_count[0]";?></span></i></b>
        </a>
      </li>

     
    </ul> 
    <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form -->
    <ul class="navbar-nav ">
     
      <li class="nav-item">
        <a class="nav-link" href="logout.php">
          <i class="fa fa-envelope-o">
          </i>
          Déconnexion
        </a>
      </li>
    </ul>
    
  </div>
</nav>
    
    
    <?php
      $q1="SELECT count(*) FROM admin";
      $q2="SELECT count(*) FROM users";
      $q3="SELECT count(*) FROM questions";
     
      $d1=mysqli_query($conn,$q1);
      $d2=mysqli_query($conn,$q2);
      $d3=mysqli_query($conn,$q3);
      
      $admin_count=mysqli_fetch_row($d1);
      $users_count=mysqli_fetch_row($d2);
      $ques_count=mysqli_fetch_row($d3);
      
      echo "<p></p><table border='1' align='center'><tr><th>Total des admins</th><th>Total des utilisateurs</th><th>Total des sujets postés</th></tr>";
      echo "<tr>
                    <td align='center'>".$admin_count[0]."</td>
                    <td align='center'>".$users_count[0]."</td>        
                    <td align='center'>".$ques_count[0]."</td>
                    
              </tr></table><p></p>";
    ?>

    <!-- admin start -->
    <?php if(@$_GET['q']==1) {
        echo "<p></p>";
        $query="SELECT * FROM admin";
      $data=mysqli_query($conn,$query);
      echo "<table border='1' align='center'><tr><th>Identifiant</th><th>Mot de passe</th><th>Supprimer</th></tr>";
      while($row=mysqli_fetch_array($data)) {
        echo "<tr>
                    <td>".$row['userid']."</td>
                    <td>".$row['password']."</td>
                    
                    
                    <td>
                        <a href='admin.php?q=admin_delete&userid=".$row['userid']."'>Supprimer</a>
                    </td>
              </tr>";
      }
      echo "</table>";

    }
    
    ?>

    <!-- admin_delete -->
    <?php if(@$_GET['q']=='admin_delete'){
      $userid=$_REQUEST['userid'];
      $query="DELETE FROM admin where userid='$userid'"; 
    if(mysqli_query($conn,$query))
    {
      echo "<script type='text/javascript'>alert('Administrateur supprimés');</script>";
    }
    else
      echo "Erreur";
    }
          
    ?>

    <!-- users start -->
    <?php if(@$_GET['q']==2) {
      echo "<p></p>";

      $query="SELECT * FROM users";
      $data=mysqli_query($conn,$query);
      echo "<table border='1' align='center'><tr><th>Identifiant</th><th>Nom et prenoms</th><th>Mt de passe</th><th>E-mail</th><th>Numero</th><th>Genre</th><th>Editer</th><th>Supprimer</th></tr>";
      while($row=mysqli_fetch_array($data)) {
        echo "<tr>
                    <td>".$row['userid']."</td>
                    <td>".$row['name']."</td>
                    <td>".$row['password']."</td>
                    <td>".$row['email']."</td>
                    <td>".$row['mobile']."</td>
                    <td>".$row['gender']."</td>
                    <td>
                        <a href='admin.php?q=user_edit&userid=".$row[0]."&name=".$row[1]."%20&password=".$row[2]."%20&email=".$row[3]."%20&mobile=".$row[4]."%20&gender=".$row[5]."%20'>Editer</a>
                    </td>
                    <td>
                        <a href='admin.php?q=user_delete&userid=".$row['userid']."'>Supprimer</a>
                    </td>
              </tr>";
      }
      echo "</table>";

    }
    ?>

    <!-- user_edit (html form) -->
    <?php if(@$_GET['q']=='user_edit')
          {
            $userid=$_REQUEST['userid'];
            $name=$_REQUEST['name'];
            $password=$_REQUEST['password'];
            $email=$_REQUEST['email'];
            $mobile=$_REQUEST['mobile'];
            $gender=$_REQUEST['gender'];
            
            echo "<form action='admin.php?q=user_update&userid=$userid' method='post' align='center'>
                  Nom <input type='text' name='name' value=".$name."/><br/>
                  Mot de passe <input type='text' name='password' value=".$password."/><br/>
                  E-mail <input type='text' name='email' value=".$email."/><br/>
                  Numéro <input type='text' name='mobile' value=".$mobile."/><br/>
                  Genre <input type='text' name='gender' value=".$gender."/><br/>
                  <input type='submit' value='Sauvégarder'/> &nbsp;&nbsp;&nbsp;&nbsp;
                  <a href='admin.php?q=2'><input type='button' value='Annuler'/></a>
                  </form>";
          }

    ?>
    <!-- user_update -->
    <?php if(@$_GET['q']=='user_update')
          {
            $userid=$_REQUEST['userid'];
            $name=$_POST['name'];
            $password=$_POST['password'];
            $email=$_POST['email'];
            $mobile=$_POST['mobile'];
            $gender=$_POST['gender'];
            $query="UPDATE users SET name='$name',password='$password',email='$email',mobile='$mobile' where userid='$userid'";
            if(mysqli_query($conn,$query))
            {
              echo "<script type='text/javascript'>alert('Informations mise à jour');</script>";
            }
            else
              echo "Mise à jour annulée";
            
          }
     ?>

     <!-- user_delete -->
    <?php if(@$_GET['q']=='user_delete'){
      $userid=$_REQUEST['userid'];
      
      $result=mysqli_query($conn,"SELECT qid from questions where userid='$userid'");
      $qid=mysqli_fetch_row($result);
      $qid=$qid[0];
      $query1="DELETE FROM questions where userid='$userid'";
      $query2="DELETE FROM answers where qid='$qid'";
      $query5="DELETE FROM answers where userid='$userid'";
      $query3="DELETE FROM user_notifications where userid='$userid'";
      $query4="DELETE FROM users where userid='$userid'"; 
      
     
      mysqli_query($conn,$query1)?print"<script type='text/javascript'>alert('Sujet supprimé');</script>":print "<script type='text/javascript'>alert('Erreur de suppression du sujet');</script>";
      mysqli_query($conn,$query2)?print"<script type='text/javascript'>alert('Réponse supprimée');</script>":print "<script type='text/javascript'>alert('Erreur de suppression de la réponse');</script>";
      mysqli_query($conn,$query5)?print"<script type='text/javascript'>alert('Réponse supprimée');</script>":print "<script type='text/javascript'>alert('Erreur de suppression de la réponse');</script>";
      mysqli_query($conn,$query3)?print"<script type='text/javascript'>alert('notifications supprimées');</script>":print "<script type='text/javascript'>alert('Erreur de suppression de la notification');</script>";
      mysqli_query($conn,$query4)?print"<script type='text/javascript'>alert('Utilisateur supprimé');</script>":print "<script type='text/javascript'>alert('Erreur de suppression de l'utilisateur');</script>";
        
      
    }
          
    ?>

    <!-- questions start -->
    <?php if(@$_GET['q']==3) {
      echo "<p></p>";
      $query="SELECT * FROM questions order by `date` desc";
      $data=mysqli_query($conn,$query);
      echo "<table border='1' align='center'><tr><th>Id du sujet</th><th>Sujet</th><th>Id utilisateur</th><th>Supprimer</th></tr>";
      while($row=mysqli_fetch_array($data)) {
        echo "<tr><td>".$row['qid']."</td><td>".$row['question']."</td><td>".$row['userid']."</td>
                  <td><a href='admin.php?q=ques_delete&qid=".$row['qid']."'>Supprimer</a></td>
              </tr>";
      }
      echo "</table>";
    }

    ?>

    <!-- ques_delete -->
    <?php 
      if(@$_GET['q']=='ques_delete')
      {
        $qid=$_REQUEST['qid'];
        $query1="DELETE FROM answers where qid='$qid'"; 
         
        if(mysqli_query($conn,$query1))
        {
          $query2="DELETE FROM questions where qid='$qid'";
          mysqli_query($conn,$query2)?print"<script type='text/javascript'>alert(Sujet supprimé');</script>":print "Erreur de suppresion du sujet";
          
        }
        else
          echo "<script type='text/javascript'>alert('Erreur de suppression de la réponse pour le sujet');</script>";
      }
    
    ?>




    <!-- answers start -->
    <?php if(@$_GET['q']==4) {
      echo "<p></p>";
      $query="SELECT * FROM answers order by qid";
      $data=mysqli_query($conn,$query);
      
      echo "<table border='1' align='center'><tr><th>Id de réponse</th><th>Réponses</th><th>Sujets</th><th>Utilisateurs</th><th>Supprimer</th></tr>";
      while($row=mysqli_fetch_array($data)) {
        $qid=$row['qid'];
        $query1="SELECT question FROM questions WHERE qid='$qid'";
        $data1=mysqli_query($conn,$query1);
        $row1=mysqli_fetch_row($data1);
        echo "<tr><td>".$row['aid']."</td><td>".$row['answer']."</td><td>".$row1[0]."</td><td>".$row['userid']."</td>
                  <td><a href='admin.php?q=ans_delete&aid=".$row['aid']."'>Supprimer</a></td>
              </tr>";
      }
      echo "</table>";
    }

    ?>

    <!-- ans_delete -->
    <?php 
      if(@$_GET['q']=='ans_delete')
      {
        $aid=$_REQUEST['aid'];
        $query="DELETE FROM answers where aid='$aid'"; 
        if(mysqli_query($conn,$query))
        {
          echo "<script type='text/javascript'>alert('Réponse supprimée');</script>";
        }
        else
          echo "Erreur";
      }
    
    ?>



    <!-- report start -->
    <?php if(@$_GET['q']==5) {
      echo "report";
    }

    ?>

<!-- admin_notifications -->
<?php if(@$_GET['q']==6){
        $query = "Select * from admin_notifications order by `date` desc";
        $notifs = mysqli_query($conn,$query);
        echo "<table border='1' align='center'><tr><th>Id Notification</th><th>Notifications</th><th>Date</th><th>Supprimer</th></tr>";
        while($row=mysqli_fetch_array($notifs))
        {
            echo "<tr>
                        <td>".$row['notifid']."</td>
                        <td>".$row['notification']."</td>
                        <td>".$row['date']."</td>
                        <td>
                            <a href='admin.php?q=notif_delete&notifid=".$row['notifid']."'>Supprimer</a>
                        </td>
                </tr>";
        }}
        
    ?>
<!-- notif_delete -->
    <?php if(@$_GET['q']=='notif_delete'){
          $notifid=$_REQUEST['notifid'];
          $query="DELETE FROM admin_notifications where notifid='$notifid'"; 
          if(mysqli_query($conn,$query))
          {
            echo "<script type='text/javascript'>alert('Notification supprimée');</script>";
          }
          else
            echo "Erreur";
    }

    ?>
</body>
</html>