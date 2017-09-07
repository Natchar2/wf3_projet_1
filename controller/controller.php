<?php
    session_start();
    //$_SESSION['name'] = "natchar";
    require('include/function.inc.php');
    
    $page = "listeArticles.php";

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
                if(isset($_SESSION['name']) && !empty($_SESSION['name']))
                {
                    $page = "listeArticles.php";
                }
                else
                {
                    $page = "inscription.php";
                }
            }
            else
            {
                if(isset($_SESSION['name']) && !empty($_SESSION['name']))
                {
                    if($page == 'inscription.php' || $page == 'connexion.php') $page = "listeArticles.php";
                    
                    if($page == "admin.php")
                    {
                        if(!isAdmin($_SESSION['name'])) $page = "listeArticles.php";
                    }
                }
                else
                {
                    if($page == "inscription.php")
                    {
                        $page = "inscription.php";
                    }
                    else
                    {
                        $page = "connexion.php";
                    }
                }
                
            }
        }
    }

    $page = "pages/" . $page;
?>