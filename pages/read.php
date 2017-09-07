<?php 
require('./include/connexion.inc.php');
require('./include/function.inc.php');
if(isset($_GET['id_article']) AND is_numeric($_GET['id_article']))
{
    //on appelle la fonction de lecture 
    if(!isArticle($_GET['id_article']))
    {
        $errors[]='Il n\'y\'a pas d\'article associé ';
    }
        else
        {
            $verifArticle = $bdd->prepare('SELECT * FROM articles WHERE id =:id_article');
            $verifArticle->bindValue('id_article',$_GET['id_article']);
            $verifArticle->execute();
            $result = $verifArticle->fetch(PDO::FETCH_OBJ);
            $infosCat = $bdd->query("SELECT * FROM categories WHERE id = '$result->categorie'");
            $categorie = $infosCat->fetch(PDO::FETCH_OBJ);
            $infosClasse = $bdd->query("SELECT * FROM classe WHERE id = '$result->classe'");
            $classe = $infosClasse->fetch(PDO::FETCH_OBJ);
            
            $afficheArticle = '<table width="50%">';
            $afficheArticle.='<tr align="center"><td colspan="2" ><strong>Titre : '.htmlspecialchars($result->titre).'</strong></td><td> Ecrit par : '.htmlspecialchars($result->auteur).'</tr>';
            $afficheArticle.='<tr><td colspan="3"><i> '.htmlspecialchars($result->contenu).'<i></td></tr>';
            $afficheArticle.='<tr><td>Catégorie : '.htmlspecialchars($classe->niveauClasse).' </td><td>Niveau : '.htmlspecialchars($categorie->nameCategorie).' </td><td>Date de publication : '.htmlspecialchars(date("d-m-Y", $result->datePublication)).'</td></tr>';
            $afficheArticle.='</table>';
        }
}
    else
    {
        $errors[] ='L\'id de l\'article est mal renseigné';
    }

?>
<a href="index.php" class="btn btn-primary">Retour à la liste des articles</a>
<?php
if(isset($errors))
{
    foreach($errors as $error)
    {
        echo '<div class="alert alert-danger">'.$error.'</div>';
    }
}
if(isset($afficheArticle))
{
    echo $afficheArticle;
}
?>    