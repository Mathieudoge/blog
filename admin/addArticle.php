<?php 

include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');

$view = 'addArticle.phtml';
$error = '';
session_start();
if(isLogged(RANK_ADMIN) == true){
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
        $image = $_POST['image'];
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
            $stmt = $dbh->prepare('INSERT INTO articles (title,created_date, content, substitle, status, categories_id)
                                    VALUES (:title, :date, :content, :substitle, :status, :category)');
            $stmt->bindValue('title', $title);
            $stmt->bindValue('date',$date->format("Y-m-d H:i:s"));
            $stmt->bindValue('content', $content);
            $stmt->bindValue('substitle', $substitle);
            $stmt->bindValue('status', $status);
            $stmt->bindValue('category', $idCategory);
            $stmt->execute();
            }
            catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }
}

include('tpl/layout.phtml');