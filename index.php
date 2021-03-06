<?php
    require('controller/controller.php');
?>


<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Aide au Devoir</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <nav>
            <ul class="nav nav-tabs">
                <li role="presentation"><a href="index.php?page=listeArticles">Accueil</a></li>
                <li role="presentation"><a href="index.php?page=inscription">Inscription</a></li>
                <li role="presentation"><a href="index.php?page=connexion">Connexion</a></li>
                <li role="presentation"><a href="index.php?page=admin">Administration</a></li>
                <li role="presentation"><a href="index.php?page=profil">Profil</a></li>
                <li role="presentation"><a href="index.php?page=deconnexion">Déconnexion</a></li>
            </ul>
        </nav>
        
        <?php
            if(isset($page))
            {
                //Inclusion de la page demandé
                include($page);
            }
            else
            {
               include("pages/listeArticles.php");
            }
        ?>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="js/script.js"></script>
    </body>

</html>
