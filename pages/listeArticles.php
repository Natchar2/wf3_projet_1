<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<?php require('../include/connexion.inc.php');
require('../include/function.inc.php');
$infosCat = $bdd->query("SELECT * FROM categories");
$categories = $infosCat->fetchAll(PDO::FETCH_OBJ);
// on recherche les niveaux
$infosClasse = $bdd->query("SELECT * FROM classe");
$classes = $infosClasse->fetchAll(PDO::FETCH_OBJ);
// ON REGARDE SI UNE OPTION A ETE CHOISI
// SI C'EST LA CLASSE : 
if(isset($_GET['id_classe']) AND is_numeric($_GET['id_classe']))
{
    //on appelle la fonction d'affichage
    $articlesClasse = afficherArticlesByClasse($_GET['id_classe']);
    $getClasse = 1;
}
if(isset($_GET['id_cat']) AND is_numeric($_GET['id_cat']))
{
    //on appelle la fonction d'affichage
    $articlesCategory =afficherArticlesByCategory($_GET['id_cat']);
    $getCat = 1;
}
if(!isset($_GET['id_cat']) AND !isset($_GET['id_classe']))
{
    $articles =afficherArticles();
}

if(isset($articlesClasse) and !empty($articlesClasse))
{
  $listeArticleClasse = '<table class="table"><tr><th>Nom</th><th>Auteur</th><th>Classe</th><th>Catégorie</th><th>Date de publication</th><th> Plus d\'action';
  foreach($articlesClasse as $articleClasse)
  {
        $infosCat = $bdd->query("SELECT * FROM categories WHERE id = '$articleClasse->categorie'");
        $categorie = $infosCat->fetch(PDO::FETCH_OBJ);
        $infosClasse = $bdd->query("SELECT * FROM classe WHERE id = '$articleClasse->classe'");
        $classe = $infosClasse->fetch(PDO::FETCH_OBJ);
      
        $listeArticleClasse.='<tr><td>'.$articleClasse->titre.'</td><td>'.$articleClasse->auteur.'</td><td>'.htmlspecialchars($classe->niveauClasse).'</td><td>'.htmlspecialchars($categorie->nameCategorie).'</td><td>'.htmlspecialchars(date("d-m-Y", $articleClasse->datePublication)).'</td><td><a href="index.php?page=read&id_article='.$articleClasse->id.'" class="btn btn-success">Lire</a></td>';
  }
   $listeArticleClasse.= '</table>';
}
//on affiche les articles par catégories.
if(isset($articlesCategory) and !empty($articlesCategory))
{
  $listeArticleCategory = '<table class="table"><tr><th>Nom</th><th>Auteur</th><th>Classe</th><th>Categorie</th><th>Date de publication</th><th> Plus d\'action';
  foreach($articlesCategory as $articleCategory)
  {
        $infosCat = $bdd->query("SELECT * FROM categories WHERE id = '$articleCategory->categorie'");
        $categorie = $infosCat->fetch(PDO::FETCH_OBJ);
        $infosClasse = $bdd->query("SELECT * FROM classe WHERE id = '$articleCategory->classe'");
        $classe = $infosClasse->fetch(PDO::FETCH_OBJ);
     $listeArticleCategory.='<tr><td>'.$articleCategory->titre.'</td><td>'.$articleCategory->auteur.'</td><td>'.htmlspecialchars($classe->niveauClasse).'</td><td>'.htmlspecialchars($categorie->nameCategorie).'</td><td>'.htmlspecialchars(date("d-m-Y", $articleCategory->datePublication)).'</td><td><a href="index.php?page=read&id_article='.$articleCategory->id.'" class="btn btn-success">Lire</a></td>';
  }
   $listeArticleCategory.= '</table>';
}

//on affiche les articles.
if(isset($articles) and !empty($articles))
{
  $listeArticle = '<table class="table"><tr><th>Nom</th><th>Auteur</th><<th>Classe</th><th>Categorie</th><th>Date de publication</th><th> Plus d\'action';
  foreach($articles as $article)
  {
        $infosCat = $bdd->query("SELECT * FROM categories WHERE id = '$article->categorie'");
        $categorie = $infosCat->fetch(PDO::FETCH_OBJ);
        $infosClasse = $bdd->query("SELECT * FROM classe WHERE id = '$article->classe'");
        $classe = $infosClasse->fetch(PDO::FETCH_OBJ);
      
     $listeArticle.='<tr><td>'.$article->titre.'</td><td>'.$article->auteur.'</td><td>'.htmlspecialchars($classe->niveauClasse).'</td><td>'.htmlspecialchars($categorie->nameCategorie).'</td><td>'.htmlspecialchars(date("d-m-Y", $article->datePublication)).'</td><td><a href="index.php?page=read&id_article='.$article->id.'" class="btn btn-success">Lire</a></td>';
  }
    $listeArticle.= '</table>';
}

     
?>
 <div class="row">
  <div class="col-md-4">
  <h2> Catégories</h2>
  <?php
  if(isset($categories)) // si on a des catégories
  {
      foreach($categories as $categorie)
      {
          echo '<a href="?id_cat='.$categorie->id.'" class="btn btn-primary">'.htmlspecialchars($categorie->nameCategorie).'</a><br />';
      }
  }     
?>
<h2> Niveau </h2>
<?php
if(isset($classes)) // si on a des catégories
{
    foreach($classes as $classe)
    {
        echo '<a href="?id_classe='.$classe->id.'" class="btn btn-primary">'.htmlspecialchars($classe->niveauClasse).'</a><br />';
    }
}
      
?>      
  </div>
  <div class="col-md-8">
     <h2>Liste des articles</h2>
      <?php 
      if(isset($listeArticleClasse))
      {
        echo $listeArticleClasse;
      }
      if(isset($listeArticleCategory))
      {
        echo $listeArticleCategory;
      }
      if(isset($listeArticle))
      {
        echo $listeArticle;
      }
      ?>
  </div>



</div>
