<?php
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=aidedevoir;charset=utf8','root','');
    }
    catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
?>