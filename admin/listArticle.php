<?php

session_start();

include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');

if (isLogged(RANK_AUTHOR) == true){
    $view = 'listArticle.phtml';
    try{
    $dbh = connexion();
    $stmt = $dbh->prepare('SELECT id, title, content, substitle, image, status, created_date, published_date, categories_id
                            FROM articles');
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
    if(array_key_exists('id', $_GET)){
        $table = 'articles';
        deleteContent($table);
        header('Location: listArticle.php');
    }

    include('tpl/layout.phtml');
}