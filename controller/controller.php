<?php
    session_start();
    
    //$_SESSION['name'] = "natchar";
    
    $page = "pages/listeArticles.php";

    if(isset($_GET['page']) && !empty($_GET['page']) && is_string($_GET['page']))
    {
        if(preg_match("#^\w{1,20}$#", $_GET['page']))
        {
            $page = $_GET['page'] . ".php";
            
            //Scan des fichiers contenu dans le dossiers pages
            $arrayPageExist = scandir("pages");
            
            //Trie des fichiers et dossiers
            forEach($arrayPageExist as $data)
            {
                if(!is_dir($data)) $arrayPageAvailable[] = $data;
            }
            
            //Verification de l'existance de la page demandé par l'utilisateur
            if(!in_array($page, $arrayPageAvailable))
            {
                $page = "pages/listeArticles.php";
            }
            else
            {
                $page = "pages/" . $page;
                
                if(isset($_SESSION['name']) && !empty($_SESSION['name']))
                {
                    if($page == 'inscription.php' || $page == 'connexion.php') $page = "listeArticles.php";
                }
                else
                {
                    if($page = "admin.php") $page = "listeArticles.php";
                }
            }
        }
    }

    if(!isset($_SESSION['name']) && empty($_SESSION['name'])) $page = 'pagesinscription';
?>