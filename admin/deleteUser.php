<?php
session_start();
include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');

if(isLogged(RANK_ADMIN) == true){
   if (array_key_exists('id', $_GET)){
    $id = $_GET['id'];  
    var_dump($_GET);
    try{
        $dbh = connexion();
        $stmt = $dbh->prepare('DELETE FROM users 
                                WHERE id = :id');
        $stmt->bindValue('id', $id);
        $stmt->execute();
    }
    catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }

    header('Location: listUser.php');
} 
}
