<?php
// connexion à la base de données
require('../include/connexion.inc.php');
$regex='#^[\w\sÀÁÂÃÄÅÇÑñÇçÈÉÊËÌÍÎÏÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöøùúûüýÿ\',-]{3,50}$#i';
$regexCp='#^[0-9]{5}$#i';
// on verifie si la variable POST n'est pas vide. 
if(!empty($_POST) and isset($_POST))
{
    //bloc de verification du champ pseudonyme. 
    if(empty($_POST['name']) OR !isset($_POST['name']))
    {
        $errors[] = 'Le champ Pseudonyme doit être rempli';
    }
        elseif(!preg_match($regex,$_POST['name']))
        {
            $errors[] = 'Le champ Pseudonyme n\'est pas correct';
        }
    //bloc de verification du champ password. 
    if(empty($_POST['password']) OR !isset($_POST['password']))
    {
        $errors[] = 'Le champ Password doit être rempli';
    }
        elseif(mb_strlen($_POST['password']) < 3 AND mb_strlen($_POST['password']>50))
        {
            $errors[] = 'Le champ password n\'est pas correct';
        }
    
    //bloc de verification de concordance des passwords. 
    if(empty($_POST['confirm_password']) OR !isset($_POST['confirm_password']))
    {
        $errors[] = 'Le champ de confirmation du password doit être rempli';
        
    }
        elseif($_POST['confirm_password'] !== $_POST['password'])
        {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }
    
    
    //bloc de verification du champ courriel. 
    if(empty($_POST['email']) OR !isset($_POST['email']))
    {
        $errors[] = 'Le champ email doit être rempli';
    
    }
        elseif(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
        {
            $errors[] = 'Le champ email n\'est pas correct';
        }
    
    //bloc de verification de concordance des passwords. 
    if(empty($_POST['confirm_email']) OR !isset($_POST['confirm_email']))
    {
        $errors[] = 'Le champ de confirmation du courriel doit être rempli';
        
    }
        elseif($_POST['confirm_email'] !== $_POST['email'])
        {
            $errors[] = 'Les courriels ne correspondent pas.';
        }
    
    //bloc de verification des classes
    if(empty($_POST['classe']) OR !isset($_POST['classe']))
    {
        $errors[] = 'Le champ Classe doit être rempli';
        
    }
        elseif(!is_numeric($_POST['classe']))
        {
            $errors[] = 'Le champ classe n\'est pas correct';
        }
    
    //bloc de verification de l'adresse
    if(empty($_POST['adresse']) OR !isset($_POST['adresse']))
    {
        $errors[] = 'Le champ adresse doit être rempli';
        
    }
        elseif(mb_strlen($_POST['adresse']) < 3 AND mb_strlen($_POST['adresse']>200))
        {
            $errors[] = 'Le champ adresse n\'est pas correct';
        }
    //bloc de verification de l'adresse
    if(empty($_POST['codePostal']) OR !isset($_POST['codePostal']))
    {
        $errors[] = 'Le champ code Postal doit être rempli';
        
    }
        elseif(!preg_match($regexCp,$_POST['codePostal']))
        {
            $errors[] = 'Le champ code Postal n\'est pas correct';
        }
    //bloc de verification de la ville 
    if(empty($_POST['ville']) OR !isset($_POST['ville']))
    {
        $errors[] = 'Le champ ville doit être rempli';
        
    }
        elseif(!preg_match($regex,$_POST['ville']))
        {
            $errors[] = 'Le champ ville n\'est pas correct';
        }
    
    //bloc de verification du pays
    if(empty($_POST['pays']) OR !isset($_POST['pays']))
    {
        $errors[] = 'Le champ PAYS doit être rempli';
        
    }
        elseif(!preg_match($regex,$_POST['pays']))
        {
            $errors[] = 'Le champ pays n\'est pas correct';
        }
    
    
    //SI PAS D'ERREURS
    if(empty($errors))
    {
        
        $verifUser = $bdd->prepare('SELECT COUNT(id) AS exist FROM users WHERE name =:name');
        $verifUser->bindValue('name',$_POST['name']);
        $verifUser->execute();
        $result = $verifUser->fetch(PDO::FETCH_OBJ);
        if($result->exist != 0)
        {
            $errors[] = 'Il existe déja un utilisateur portant ce nom';
        }
            else
            {
                 //INSCRIPTION EN BASE DE DONNES
        
                $cPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $inscription = $bdd->prepare('INSERT INTO users (name, password, email, classe, adresse, codePostal, ville, pays, admin) VALUES(:name, :password, :email, :classe, :adresse, :codePostal, :ville, :pays, :admin)');
                $inscription->execute(array(
				'name' => $_POST['name'],
				'password' => $cPassword,
				'email' => $_POST['email'],
                'classe' => $_POST['classe'],
                'adresse' => $_POST['adresse'],
                'codePostal' => $_POST['codePostal'],
                'ville' => $_POST['ville'],
                'pays' => $_POST['pays'],
                'admin' => false
				));
            }
       
        
    }
    
}
?>



<?php 
if(isset($errors))
{
    foreach($errors as $error)
    {
        echo '<div class="alert alert-danger">'.$error.'</div>';
    }
}
?>
<form class="form-horizontal" method="POST" action="inscription.php">
<fieldset>

<!-- Form Name -->
<legend>Inscription Aide au devoir</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Pseudonyme</label>  
  <div class="col-md-4">
  <input id="name" name="name" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Mot de passe : </label>  
  <div class="col-md-4">
  <input id="password" name="password" type="password" placeholder="" class="form-control input-md">
    
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Confirmer votre mot de passe</label>  
  <div class="col-md-4">
  <input id="confirm_password" name="confirm_password" type="password" placeholder="" class="form-control input-md">
    
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Courriel : </label>  
  <div class="col-md-4">
  <input id="email" name="email" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Confirmer votre courriel : </label>  
  <div class="col-md-4">
  <input id="confirm_email" name="confirm_email" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>
<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Classe</label>
  <div class="col-md-4">
    <select id="classe" name="classe" class="form-control">
    <?php 
    $infosClasse = $bdd->query("SELECT * FROM classe");
    $classes = $infosClasse->fetchAll(PDO::FETCH_OBJ);
    foreach($classes as $classe)
    {
        echo '<option value='.$classe->id.'>'.$classe->niveauClasse.'</option>';
    }
    ?>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="adresse">Adresse :  </label>  
  <div class="col-md-4">
  <input id="adresse" name="adresse" type="text" placeholder="" class="form-control input-md">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="codePostal">Code Postal :  </label>  
  <div class="col-md-4">
  <input id="codePostal" name="codePostal" type="text" placeholder="" class="form-control input-md">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="ville">Ville :  </label>  
  <div class="col-md-4">
  <input id="ville" name="ville" type="text" placeholder="" class="form-control input-md">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="adresse">Pays :  </label>  
  <div class="col-md-4">
  <input id="pays" name="pays" type="text" placeholder="" class="form-control input-md">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for=""></label>
  <div class="col-md-4">
    <button id="" name="" class="btn btn-primary">S'inscrire</button>
  </div>
</div>

</fieldset>
</form>
