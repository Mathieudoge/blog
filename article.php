<?php
session_start();
include('admin/lib/db.lib.php');
include('admin/config/config.php');
include('models/article.php');
$view = 'article.phtml';
$id = $_GET['id'];

$articles = listArticle();
$dbh = connexion();
$stmt = $dbh->prepare('SELECT *
                        FROM articles
                        WHERE id = :id');
$stmt->bindValue('id', $id);
$stmt->execute();
$article = $stmt->fetch(PDO::FETCH_ASSOC);


include('tpl/layout.phtml');