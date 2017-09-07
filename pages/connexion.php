<?php 
require('include/connexion.inc.php');



if(!empty($_POST)){
    
    if(isset($_POST['name']) AND !empty($_POST['name']))
    {

        if(!preg_match('#^[a-z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ\-]{3,50}$#i', $_POST['name']))
        {
            $errors[] = "Pseudo invalide";
        }
    }    
        else 
        {
            $errors[] = "Veuillez remplir le champ Pseudo!";
        }   
	if(isset($_POST['password']) AND !empty($_POST['password']))
    {

		if(!preg_match('#^[a-z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ\-]{3,50}$#i', $_POST['password']))
        {

			$errors[] = "Mot de passe invalide !";
        }
	} else {

		$errors[] = "Veuillez remplir le champ mot de passe !";
	}

	if(!isset($errors)){
		$requete= $bdd->prepare('SELECT password FROM users WHERE name= :name');

		$requete->bindValue(':name', $_POST['name']);
		
		$requete->execute();
		if ($requete->rowCount()>0) {
			$password=$requete->fetch();
			
			if(password_verify($_POST['password'], $password[0])){
				$_SESSION['name']= htmlspecialchars($_POST['name']);
				$success = "Connecté, vous pouvez aller sur la page d'accueil !";

			}else{
				$errors[] = "Mot de passe incorrect !";

			}
			
		}else{

			$errors[] = "Votre Pseudo ou votre mot de passe n'est pas bon !";
		}

	}

}

?>

<div id="view">
	<form class="col-xs-6 col-xs-offset-3" action="index.php?page=connexion" method="POST">
		<div class="form-group">
			<label class="control-label" for="name">Pseudo:</label>
			<input name="name" id="name" type="text" class="form-control">	
		</div>
		<div class="form-group">
			<label class="control-label" for="password">Mot de passe:</label>
			<input name="password" id="password" type="password"  class="form-control">	
		</div>
		<button type="submit" class="btn btn-primary">Envoyer</button>
	</form>
</div>
<?php


if(isset($errors)){
	foreach($errors as $error){
		echo '<p style="color:red;">'.$error.'</p>';
	}
}

if(isset($success)){
	echo '<p style="color:green;">'.$success.'</p>';
}
?>
