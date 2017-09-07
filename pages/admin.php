<nav>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="index.php?page=admin&action=list">Lister les articles</a></li>
        <li role="presentation"><a href="index.php?page=admin&action=add">Ajouter un article</a></li>
    </ul>
</nav>


<?php
    if(isset($_GET['action']) && !empty($_GET['action']))
    {
        if($_GET['action'] == "list") include("admin/accueiladmin.php");
        if($_GET['action'] == "add") include("admin/add.php");
    }
?>