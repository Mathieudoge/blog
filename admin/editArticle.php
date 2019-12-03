<?php 
session_start();

include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');
include('../models/article.php');

$view = 'editArticle.phtml';
$error = '';
try{
    if(isLogged(RANK_AUTHOR) == true){
        $id = $_GET['id'];
        $article = getArticle($id);
        var_dump($article);
        $categories = getCategories();
        if(array_key_exists('category', $_POST)){
            var_dump($_POST);
            $id = $_POST['id'];
            $getCategory = $_POST['category'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $substitle = $_POST['substitle'];
            $image = addImage('../images/articles/');
            $error = $image['error'];
            $status = $_POST['status'];
            $category = getCategory($getCategory);
            $idCategory = $category['id'];
            deleteImage('articles',$id,'../images/articles/','image');
            if($error == ''){           
                updateArticle($id,$title,$content,$image['image'],$substitle,$status,$idCategory);
                header('Location: listArticle.php'); 
                exit();
            }
        }
        include('tpl/layout.phtml');
    }
}
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

