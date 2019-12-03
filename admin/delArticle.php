<?php 
session_start();
include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');
include('../models/article.php');

try{
    if (isLogged(RANK_AUTHOR) == true && array_key_exists('id', $_GET)){
        $id = $_GET['id'];
        $dir =  '../images/articles/';
        deleteArticle($id,$dir);
        header('Location: listArticle.php');
        exit();
    }    
}
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}