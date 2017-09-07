<?php
function isAdmin($users)
{
   require('connexion.inc.php'); // on appelle la connexion PDO.
    $verifAdmin = $bdd->prepare('SELECT COUNT(id) AS isAdmin FROM users WHERE name =:name AND admin=1');
    $verifAdmin->bindValue('name',$users);
    $verifAdmin->execute();
    $result = $verifAdmin->fetch(PDO::FETCH_OBJ);
    if($result->isAdmin == 1)
    {
        return true;
        
    }
    else
    {
        return false;
    }
}

function deleteArticle($id_article)
{
    if(!is_numeric($id_article) AND $id_article > 0)
    {
        trigger_error("ID ARTICLE INCORRECT", E_USER_ERROR);
    }
    
    else // on fait les tests
    {
        require('connexion.inc.php');
        $verifArticle = $bdd->prepare('SELECT COUNT(id) AS isArticle FROM articles WHERE id = :id_article');
        $verifArticle->bindValue('id_article',$id_article);
        $verifArticle->execute();
        $result = $verifArticle->fetch(PDO::FETCH_OBJ);
        if($result->isArticle != 1)
        {
            return false;
        }
        else
        {
            $deleteArticle = $bdd->prepare('DELETE FROM articles WHERE id = :id_article');
            $deleteArticle->bindValue('id_article',$id_article);
            $deleteArticle->execute();
            return true;
        }
                
            
    }
}
function afficherArticlesByClasse($id_classe)
{
    require('../include/connexion.inc.php');
    if(!is_numeric($id_classe) OR empty($id_classe))
    {
         trigger_error("ID CLASSE", E_USER_ERROR);
    }
    
    $articleByClasse = $bdd->prepare('SELECT * FROM articles WHERE classe = :id_classe');
    $articleByClasse->bindValue('id_classe',$id_classe);
    $articleByClasse->execute();
    $result = $articleByClasse->fetchAll(PDO::FETCH_OBJ);
    return $result;
}
function afficherArticlesByCategory($id_category)
{
    require('../include/connexion.inc.php');
    if(!is_numeric($id_category) OR empty($id_category))
    {
         trigger_error("ID CATEGORY", E_USER_ERROR);
    }
    
    $articleByCat = $bdd->prepare('SELECT * FROM articles WHERE categorie = :id_category');
    $articleByCat->bindValue('id_category',$id_category);
    $articleByCat->execute();
    $resultCat = $articleByCat->fetchAll(PDO::FETCH_OBJ);
    return $resultCat;
}
function afficherArticles()
{
    require('../include/connexion.inc.php');
    $totalArt = $bdd->query('SELECT * FROM articles');
    $resultArt = $totalArt->fetchAll(PDO::FETCH_OBJ);
    return $resultArt;
}


?>