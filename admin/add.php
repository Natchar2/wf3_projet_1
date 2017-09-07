<?php
    include("include/connexion.inc.php");
    if(!isAdmin($_SESSION['name']))
    {
        $errors[]='Vous n\êtes pas autorisé à accéder à cette page';
        $displayForm = 0;
    }
        else
        {
            $displayForm = 1;
        }
    if(isset($_POST) && !empty($_POST))
    {
        $regex='#^[\w\sÀÁÂÃÄÅÇÑñÇçÈÉÊËÌÍÎÏÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöøùúûüýÿ!?\',-]{3,50}$#i';
        $regexContenu = '#^[\w\sÀÁÂÃÄÅÇÑñÇçÈÉÊËÌÍÎÏÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöøùúûüýÿ!?\',-]{1,3000}$#i';
        $regexSelect = '#^[\d]{1}$#i';
        
        $errors[] = verifDataPost("titre", $_POST['titre'], $regex, "Le titre renseigné n'est pas valide");
        $errors[] = verifDataPost("auteur", $_POST['auteur'], $regex, "L'auteur renseigné n'est pas valide");
        $errors[] = verifDataPost("contenu", $_POST['contenu'], $regexContenu, "Votre contenu n'est pas valide");
        $errors[] = verifDataPost("categorie", $_POST['categorie'], $regexSelect, "Votre catégorie n'est pas valide");
        $errors[] = verifDataPost("classe", $_POST['classe'], $regexSelect, "Votre classe n'est pas valide");
        
        //print_r($errors);
        foreach($errors as $key => $error)
        {
            if(empty($error))
            {
                unset($errors[$key]);
            }
            if(count($errors) == 0) unset($errors);
        }
        
        if(!isset($errors))
        {
            $req = $bdd->prepare('INSERT INTO articles (titre, auteur, contenu, categorie, classe, datePublication) VALUES (:titre, :auteur, :contenu, :categorie, :classe, :datePublication)');
            $req->bindValue(':titre', $_POST['titre']);
            $req->bindValue(':auteur', $_POST['auteur']);
            $req->bindValue(':contenu', $_POST['contenu']);
            $req->bindValue(':categorie', $_POST['categorie']);
            $req->bindValue(':classe', $_POST['classe']);
            $req->bindValue(':datePublication', time());
            $req->execute();
            
            if($req->rowCount() > 0)
            {
                $success = "Votre article a bien été ajouté";
            }
            else
            {
                $errors[][0] = "Une erreur s'est produite veuillez réessayer";
            }
        }
        
    }
?>

<h1>Ajouter un Article</h1>

<?php
    

    if(isset($errors))
    {
        foreach($errors as $error)
        {
            echo '<p class="alert alert-danger col-md-10 col-md-offset-1">' . $error[0] . '</p>';
        }
    }

    if(isset($success)) echo '<p class="alert alert-success col-md-10 col-md-offset-1">' . $success . '</p>';

    if(isset($displayForm) AND $displayForm != 0)
    {
        
   
?>

<form action="" method="POST" class="form-horizontal">
    <div class="form-group">
        <label class="col-md-4 control-label" for="name">Titre</label>  
        <div class="col-md-4">
            <input id="name" name="titre" type="text" placeholder="" class="form-control input-md">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-md-4 control-label" for="auteur">Auteur</label>  
        <div class="col-md-4">
            <input id="name" name="auteur" type="text" placeholder="" class="form-control input-md">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-md-4 control-label" for="name">Contenu</label>  
        <div class="col-md-4">
            <input id="name" name="contenu" type="text" placeholder="" class="form-control input-md">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-md-4 control-label" for="categorie">Categorie</label>
        <div class="col-md-4">
            <select id="categorie" name="categorie" class="form-control">
                <?php
                    $infoscategorie = $bdd->query("SELECT * FROM categories");
                    $categories = $infoscategorie->fetchAll(PDO::FETCH_OBJ);
                    foreach($categories as $categorie)
                    {
                        echo '<option value='.$categorie->id.'>'.$categorie->nameCategorie.'</option>';
                    }
                    $infoscategorie->closeCursor();
                ?>
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-md-4 control-label" for="classe">Classe</label>
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
    
    <div class="col-md-offset-4">
        <input type="submit" class="btn btn-primary">
    </div>
</form>
<?php
    }
?>