<?php 
session_start() ;
include_once('connexionDB.php');  // connection a la base de donnée
if(!empty($_POST)){   //verification complete 
    extract($_POST);
    $valid = (boolean) true;
    if (isset($_POST['connexion'])){//Si on valide l'inscription les valeurs rentrées vont se mettre dans des variables
      $mail = (String) strtolower( trim($mail));
      $password = (String) trim($password);

      if (empty($mail)) { //si la case est vide alors ça affiche un message
        $valid=false;
        $err_mail = "Veuillez renseigner votre mail !";
      
    }else{
      $req = $BDD->prepare("SELECT id
        FROM utilisateur
        WHERE mail = ?");

      $req->execute(array($mail));
      $utilisateur = $req->fetch();

    
    if(!isset($utilisateur['id'])){
      $valid = false;
      $err_mail = "Veuillez renseigner ce champs !";
    }
  }
    if (empty($password)) { 
        $valid=false;
        $err_password = "Veuillez renseigner ce champs !";
  }
  $req = $BDD->prepare("SELECT id
        FROM utilisateur
        WHERE mail = ? AND password = ?");

      $req->execute(array($mail , crypt($password)));
      $utilisateur = $req->fetch();
      if($valid){
        $req = $BDD->prepare("SELECT *
        FROM utilisateur
        WHERE id = ?");

      $req->execute($verif_utilisateur['id']);
      $verif_utilisateur = $req->fetch();
      $_SESSION['id'] = $verif_utilisateur['id'];
      $_SESSION['pseudo'] = $verif_utilisateur['pseudo'];
      $_SESSION['mail'] = $verif_utilisateur['mail'];
        header('Location: /');
        exit;
      }
    }
  }

  ?>
<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">




    <title>Connexion</title>
  </head>
  <body>
<?php require_once('Menu.php') ?>
    <h1>Se Connecter</h1>

    <form method="post">
          <section>
            <div>
               <?php
                 if (isset($err_mail)) {   //si il y a une erreur alors ça affiche un message
                  echo $err_mail;
                      
                 }
               ?>
              <input type="text" name="mail" placeholder="Mail" value="<?php if(isset($mail)){echo $mail;} ?>">
            </div>
            <div>
               <?php
                 if (isset($err_password)) {    //si il y a une erreur alors ça affiche un message
                  echo $err_password;
                      
                 }
               ?>
              <input type="password" name="password" placeholder="Mot de Passe" value="<?php if(isset($password)){echo $password;} ?>">
            </div>
          </section>

        
            <input type="submit" name="connexion" value="Se connecter" />
    </form>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>