<?php 
session_start();

include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');
include('../models/article.php');

$view = 'addArticle.phtml';
$error = '';
try{
    if(isLogged(RANK_AUTHOR) == true){
        $categories = getCategories();
        if(array_key_exists('category', $_POST)){
            $getCategory = $_POST['category'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $substitle = $_POST['substitle'];
            $image = addImage('..images/articles/');
            $error = $image['error'];
            $status = $_POST['status'];
            $category = getCategory($getCategory);
            $idCategory = $category['id'];
            if($error == ''){
                $date = new DateTime();
                addArticle($title,$date,$content,$image['image'],$substitle,$status,$idCategory);
                header('Location: listArticle.php'); 
                exit();
            }
        }
    }
}
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

include('tpl/layout.phtml');