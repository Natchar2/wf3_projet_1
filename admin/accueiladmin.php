<?php
// on appelle les fichiers importants. 

require('./include/connexion.inc.php');
// on teste si l'utilisateur est admin. 
if(isAdmin($_SESSION['name'])) //$_SESSION['name'];
{
    if(isset($_GET['id_article']) AND is_numeric($_GET['id_article']))
    {
        if(!deleteArticle($_GET['id_article'])) //
        {
            $errors[]='Suppression de l\'article impossible';
        }
        else
        {
            $success = 'Article supprimé';
        }
    }
    
    
    $infosArticles = $bdd->query("SELECT * FROM articles");
    $articles = $infosArticles->fetchAll(PDO::FETCH_OBJ);
    $listeArticle = '<table class="table"><tr><th>ID</th><th>Nom</th><th>Auteur</th><th>Categorie</th><th>Classe</th><th>Date de publication</th><th> Plus d\'action</th>';
    foreach($articles as $article)
    {
        //on recupere les id des categories
        $infosCat = $bdd->query("SELECT * FROM categories WHERE id = '$article->categorie'");
        $categorie = $infosCat->fetch(PDO::FETCH_OBJ);
        
        //on recupere les id des niveau
        $infosClasse = $bdd->query("SELECT * FROM classe WHERE id = '$article->classe'");
        $classe = $infosClasse->fetch(PDO::FETCH_OBJ);
        
        // on affiche la liste des articles
        $listeArticle.='<tr><td>'.htmlspecialchars($article->id).'</td><td>'.htmlspecialchars($article->titre).'</td><td>'.htmlspecialchars($article->auteur).'</td><td>'.htmlspecialchars($categorie->nameCategorie).'</td><td>'.htmlspecialchars($classe->niveauClasse).'</td><td>'.htmlspecialchars(date("d-m-Y", $article->datePublication)).'</td><td><a href="index.php?page=admin&id_article='.htmlspecialchars($article->id).'" class="btn btn-danger">Supprimer</a></td></tr>';
    }

    $listeArticle.='</table>';
    
}
else
{
    $errors[]='Vous n\'êtes pas autorisé à accéder à cette page';
}


?>
<h2>Administration</h2>
<?php
// on gere l'affiche des différents eléments

if(isset($listeArticle)) // si la liste des articles est défini.
{
    echo $listeArticle; 
}
if(isset($errors)) //si il y'a des erreurs on affiche la page des erreurs. 
{
    foreach($errors as $error)
    {
        echo '<div class="alert alert-danger">'.$error.'</div>';
    }
}
if(isset($success))
{
    echo '<div class="alert alert-success">'.$success.'</div>';
}


?>