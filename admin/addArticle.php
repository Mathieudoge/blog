<?php 
session_start();

include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');

$view = 'addArticle.phtml';
$error = '';

if(isLogged(RANK_AUTHOR) == true){
    $dbh = connexion();
    $stmt = $dbh->prepare('SELECT name, id
                                FROM categories');
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(array_key_exists('category', $_POST)){
        $getCategory = $_POST['category'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $substitle = $_POST['substitle'];
        $image = addImage();
        $error = $image['error'];
        $status = $_POST['status'];

        $stmt = $dbh->prepare('SELECT name, id
                                FROM categories
                                WHERE name = :name');
        $stmt->bindValue('name', $getCategory);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        $idCategory = $category['id'];
        if($error == ''){
            try{
            $date = new DateTime();
            $stmt = $dbh->prepare('INSERT INTO articles (title,created_date, content, image, substitle, status, categories_id)
                                    VALUES (:title, :date, :content, :image, :substitle, :status, :category)');
            $stmt->bindValue('title', $title);
            $stmt->bindValue('date',$date->format("Y-m-d H:i:s"));
            $stmt->bindValue('content', $content);
            $stmt->bindValue('image', $image['image']);
            $stmt->bindValue('substitle', $substitle);
            $stmt->bindValue('status', $status);
            $stmt->bindValue('category', $idCategory);
            $stmt->execute();

            header('Location: listArticle.php');
            }
            catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }
}

include('tpl/layout.phtml');