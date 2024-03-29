<?php
$dbh = connexion();

function addArticle($title,DateTime $date,$content,$image,$substitle,$status,$idCategory)
{
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO articles (title,created_date, content, image, substitle, status, categories_id)
                                        VALUES (:title, :date, :content, :image, :substitle, :status, :category)');
    $stmt->bindValue('title', $title);
    $stmt->bindValue('date',$date->format('Y-m-d H:i:s'));
    $stmt->bindValue('content', $content);
    $stmt->bindValue('image', $image);
    $stmt->bindValue('substitle', $substitle);
    $stmt->bindValue('status', $status);
    $stmt->bindValue('category', $idCategory);
    $stmt->execute();
}
function listArticle(){
    global $dbh;
    $stmt = $dbh->prepare('SELECT a.id, title, content, substitle, image, status, created_date, published_date, categories_id, c.name
                            FROM articles a
                            INNER JOIN categories c ON a.categories_id = c.id
                            ORDER BY a.id ASC');
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $articles;
}
function getArticle($id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT a.id, title, content, substitle, image, status, categories_id, c.name
                            FROM articles a
                            INNER JOIN categories c ON a.categories_id = c.id
                            WHERE a.id = :id');
    $stmt->bindValue('id', $id);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    return $article;
}
function updateArticle($id,$title,$content,$image,$substitle,$status,$idCategory){
    global $dbh;
    $stmt = $dbh->prepare('UPDATE articles
                            SET title = :title, content = :content, image = :image, substitle = :substitle, status = :status, categories_id = :category
                            WHERE id = :id');
    $stmt->bindValue('title', $title);
    $stmt->bindValue('content', $content);
    $stmt->bindValue('image', $image);
    $stmt->bindValue('substitle', $substitle);
    $stmt->bindValue('status', $status);
    $stmt->bindValue('category', $idCategory);
    $stmt->bindValue('id', $id);
    $stmt->execute();
}
function deleteArticle($id,$dir)
{
    var_dump($id);
    var_dump($dir);
    deleteContent('articles',$id,$dir,'image');
}
function getCategory($getCategory){
    global $dbh;
    $stmt = $dbh->prepare('SELECT name, id
                            FROM categories
                            WHERE name = :name');
    $stmt->bindValue('name', $getCategory);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    return $category;
}
function getCategories(){
    global $dbh;
    $stmt = $dbh->prepare('SELECT name, id
                                    FROM categories');
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}