<?php
session_start();

include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');

if (isLogged(RANK_AUTHOR) == true){
    $view = 'listCategory.phtml';
    try{
    $dbh = connexion();
    $stmt = $dbh->prepare('SELECT id, name
                            FROM categories');
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
    if(array_key_exists('id', $_GET)){
        $table = 'categories';
        deleteContent($table);
        header('Location: listCategory.php');
    }

    include('tpl/layout.phtml');
}