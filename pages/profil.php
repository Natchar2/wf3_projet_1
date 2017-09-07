<?php if(isset($_SESSION['name']) && !empty($_SESSION['name'])): ?>
    <?php
        
        //Récupération des données de profil de l'utilisateur
        require('include/connexion.inc.php');

        $req = $bdd->prepare('SELECT * FROM users WHERE name=:name');
        $req->bindValue(':name', $_SESSION['name']);
        $req->execute();

        $res = $req->fetchAll(PDO::FETCH_OBJ);
    ?>
   
    <section>
        <h1>Information Compte</h1>

        <div>
            <h4>Pseudo: </h4> <span><?= $res[0]->name; ?></span><br/>
            <h4>Email: </h4> <span><?= $res[0]->email; ?></span><br/>
            <h4>Classe: </h4> <span><?= $res[0]->classe; ?></span><br/>
            <h4>Adresse: </h4> <span><?= $res[0]->adresse; ?></span><br/>
            <h4>Code postal: </h4> <span><?= $res[0]->codePostal; ?></span><br/>
            <h4>Ville: </h4> <span><?= $res[0]->ville; ?></span><br/>
            <h4>Pays: </h4> <span><?= $res[0]->pays; ?></span><br/>
            <?php if($res[0]->avatar != null): ?>
                <h4>Avatar: </h4> <span>Oui</span><br/>
            <?php else: ?>
                <h4>Avatar: </h4> <span>Non</span><br/>
            <?php endif; ?>

            <?php if($res[0]->admin): ?>
                <h4>Privilège: </h4> <span>Admin</span><br/>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>