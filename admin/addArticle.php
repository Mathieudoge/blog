<?php 

include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');

$view = 'addArticle.phtml';
$error = '';
session_start();
if(isLogged(RANK_ADMIN) == true){
    $dbh = connexion();
    $stmt = $dbh->prepare('SELECT name
                            FROM categories');
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(array_key_exists('category', $_POST)){
        $category = $_POST['category'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $substitle = $_POST['substitle'];
        $image = $_POST['image'];
        $visiblity = $_POST['visibility'];
    }
}

include('tpl/layout.phtml');